@extends('frontend.layouts.app')

@section('title', 'Contact')

@section('content')
    <section class="section" style="padding-top:2rem;">
        <h1 class="section-title">Contact</h1>
        <p style="margin:0 0 1rem; color:var(--muted);">Have questions about booking, services, or support? Send us a message.</p>

        <div class="card" style="max-width:720px;">
            <form method="post" action="{{ route('frontend.contact.submit') }}">
                @csrf

                <div class="form-field">
                    <label for="name">Name</label>
                    <input id="name" name="name" type="text" maxlength="255" value="{{ old('name') }}" required>
                    @error('name')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" maxlength="255" value="{{ old('email') }}" required>
                    @error('email')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="form-field">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" maxlength="2000" required>{{ old('message') }}</textarea>
                    @error('message')<div class="error">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Send message</button>
            </form>
        </div>
    </section>
@endsection
