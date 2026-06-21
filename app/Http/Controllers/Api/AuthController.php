<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        $customerRole = Role::query()->firstOrCreate(
            ['name' => 'customer'],
            ['guard_name' => 'web']
        );
        $user->roles()->sync([$customerRole->id]);

        $token = $user->createToken('api')->plainTextToken;

        return ApiResponse::success(
            [
                'token' => $token,
                'token_type' => 'Bearer',
                'user' => $this->userPayload($user),
            ],
            __('Registration successful.'),
            201
        );
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        $user = User::query()->where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return ApiResponse::error(__('These credentials do not match our records.'), null, 401);
        }

        $token = $user->createToken('api')->plainTextToken;

        return ApiResponse::success([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $this->userPayload($user),
        ], __('Login successful.'));
    }

    /**
     * @return array<string, mixed>
     */
    protected function userPayload(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
    }
}
