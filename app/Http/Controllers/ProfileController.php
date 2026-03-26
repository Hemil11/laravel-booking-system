<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Services\Media\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(
        protected FileUploadService $fileUploadService
    ) {}

    public function edit(): View
    {
        return view('profile.edit', [
            'user' => request()->user(),
        ]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->safe()->only(['name', 'email']);

        if ($request->filled('password')) {
            $data['password'] = $request->validated('password');
        }

        if ($request->hasFile('avatar')) {
            $this->fileUploadService->delete($user->avatar_path);
            $data['avatar_path'] = $this->fileUploadService->store(
                $request->file('avatar'),
                'users/'.$user->id.'/avatar'
            );
        }

        $user->update($data);

        return redirect()
            ->route('profile.edit')
            ->with('status', __('Profile updated.'));
    }
}
