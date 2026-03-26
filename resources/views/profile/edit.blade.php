@extends('layouts.app')

@section('title', 'Your profile')

@section('content')
    <h1>Your profile</h1>
    <div class="card">
        <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="field">
                <label for="name">Name</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required maxlength="255" autocomplete="name">
                @error('name')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                @error('email')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label for="avatar">Profile photo (optional)</label>
                <input id="avatar" name="avatar" type="file" accept="image/jpeg,image/png,image/gif,image/webp">
                @error('avatar')<div class="error">{{ $message }}</div>@enderror
                @if ($user->avatar_path)
                    <p style="margin: 0.5rem 0 0; font-size: 0.875rem; color: var(--muted);">Current photo:</p>
                    <img src="{{ media_url($user->avatar_path) }}" alt="" style="max-width: 120px; margin-top: 0.35rem; border-radius: 50%; border: 1px solid var(--border);">
                @endif
            </div>

            <div class="field">
                <label for="password">New password (optional)</label>
                <input id="password" name="password" type="password" autocomplete="new-password">
                @error('password')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label for="password_confirmation">Confirm new password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ url('/') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
@endsection
