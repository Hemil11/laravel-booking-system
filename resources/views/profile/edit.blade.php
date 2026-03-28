@extends('layouts.app')

@section('title', 'Your profile')

@section('content')
    <div class="mb-8">
        <h1 class="text-h1 text-text">Your profile</h1>
        <p class="mt-2 text-small text-text-muted">Update account details, avatar, and password.</p>
    </div>
    <div class="card">
        <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                <div class="space-y-1.5">
                    <label for="name" class="block text-sm font-medium text-text">Name</label>
                    <input id="name" name="name" type="text" class="input @error('name') input-error @enderror" value="{{ old('name', $user->name) }}" required maxlength="255" autocomplete="name">
                    @error('name')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="space-y-1.5">
                    <label for="email" class="block text-sm font-medium text-text">Email</label>
                    <input id="email" name="email" type="email" class="input @error('email') input-error @enderror" value="{{ old('email', $user->email) }}" required autocomplete="email">
                    @error('email')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="space-y-1.5">
                    <label for="avatar" class="block text-sm font-medium text-text">Profile photo (optional)</label>
                    <input id="avatar" name="avatar" type="file" class="input py-2 @error('avatar') input-error @enderror" accept="image/jpeg,image/png,image/gif,image/webp">
                    @error('avatar')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
                @if ($user->avatar_path)
                        <p class="mt-2 text-small text-text-muted">Current photo:</p>
                        <img src="{{ media_url($user->avatar_path) }}" alt="" class="mt-1 max-w-[120px] rounded-full border border-border">
                @endif
                </div>

                <div class="space-y-1.5">
                    <label for="password" class="block text-sm font-medium text-text">New password (optional)</label>
                    <input id="password" name="password" type="password" class="input @error('password') input-error @enderror" autocomplete="new-password">
                    @error('password')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="space-y-1.5">
                    <label for="password_confirmation" class="block text-sm font-medium text-text">Confirm new password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="input" autocomplete="new-password">
                </div>

                <div class="flex flex-wrap gap-2 pt-1">
                    <x-button type="submit">Save</x-button>
                    <x-button variant="outline" href="{{ url('/') }}">Cancel</x-button>
                </div>
            </div>
        </form>
    </div>
@endsection
