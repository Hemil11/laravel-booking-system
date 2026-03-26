@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <h1>Login</h1>
    <div class="card" style="max-width: 420px;">
        <form method="post" action="{{ route('login') }}">
            @csrf
            <div class="field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" required autocomplete="current-password">
                @error('password')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="field" style="display: flex; align-items: center; gap: 0.5rem;">
                <input id="remember" name="remember" type="checkbox" value="1">
                <label for="remember" style="margin: 0;">Remember me</label>
            </div>
            <button type="submit" class="btn btn-primary">Sign in</button>
        </form>
    </div>
@endsection
