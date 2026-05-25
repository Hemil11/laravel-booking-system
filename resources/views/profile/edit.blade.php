@extends('layouts.app')

@section('title', 'Your Profile')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold tracking-tight text-white font-display">{{ __('Your Profile') }}</h1>
        <p class="mt-2 text-sm text-slate-400">{{ __('Update account details, avatar, and security passwords.') }}</p>
    </div>
    
    <div class="card bg-[#0d1324]/30 border-white/5 shadow-2xl backdrop-blur-sm">
        <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                <div class="space-y-1.5">
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">{{ __('Name') }}</label>
                    <input id="name" name="name" type="text" class="input @error('name') input-error @enderror" value="{{ old('name', $user->name) }}" required maxlength="255" autocomplete="name">
                    @error('name')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="space-y-1.5">
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">{{ __('Email Address') }}</label>
                    <input id="email" name="email" type="email" class="input @error('email') input-error @enderror" value="{{ old('email', $user->email) }}" required autocomplete="email">
                    @error('email')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="space-y-1.5">
                    <label for="avatar" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">{{ __('Profile Photo (Optional)') }}</label>
                    <input id="avatar" name="avatar" type="file" class="input py-2 @error('avatar') input-error @enderror" accept="image/jpeg,image/png,image/gif,image/webp">
                    @error('avatar')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
                    @if ($user->avatar_path)
                        <div class="mt-4 p-3 rounded-2xl bg-white/5 border border-white/5 w-fit">
                            <p class="text-[10px] font-bold uppercase text-slate-500 mb-2">{{ __('Current Photo:') }}</p>
                            <img src="{{ media_url($user->avatar_path) }}" alt="" class="h-16 w-16 rounded-full object-cover border border-white/10 shadow-md">
                        </div>
                    @endif
                </div>

                <div class="space-y-1.5">
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">{{ __('New Password (Optional)') }}</label>
                    <input id="password" name="password" type="password" class="input @error('password') input-error @enderror" autocomplete="new-password">
                    @error('password')<div class="mt-1 text-xs font-medium text-danger">{{ $message }}</div>@enderror
                </div>

                <div class="space-y-1.5">
                    <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">{{ __('Confirm New Password') }}</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="input" autocomplete="new-password">
                </div>

                <div class="flex flex-wrap gap-3 pt-3 border-t border-white/5">
                    <button type="submit" class="btn-primary px-6 py-3 rounded-xl font-bold bg-white text-slate-950 hover:bg-slate-100 border-none shadow-md">
                        {{ __('Save Changes') }}
                    </button>
                    <a href="{{ url('/') }}" class="btn-secondary bg-white/5 border-white/10 text-white rounded-xl py-3 px-6 text-xs font-semibold">
                        {{ __('Cancel') }}
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
