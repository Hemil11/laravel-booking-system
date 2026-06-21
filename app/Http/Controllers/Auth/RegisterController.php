<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = User::query()->create($request->safe()->only(['name', 'email', 'password']));

        $customerRole = Role::query()->firstOrCreate(
            ['name' => 'customer'],
            ['guard_name' => 'web']
        );
        $user->roles()->sync([$customerRole->id]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('bookings.index'));
    }
}
