@extends('frontend.layouts.app')

@section('title', 'Contact')

@section('content')
    <section class="content-section-alt">
        <div class="mb-6">
            <h1 class="text-h1 text-text">Contact us</h1>
            <p class="mt-2 text-small text-text-muted">Have questions about booking, services, or support? Send us a message.</p>
        </div>

        <div class="grid gap-5 lg:grid-cols-[1.2fr_0.8fr]">
            <x-card header="Send a message">
                @if ($errors->any())
                    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        Please fix the highlighted fields and try again.
                    </div>
                @endif

                <form method="post" action="{{ route('frontend.contact.submit') }}" class="space-y-4">
                    @csrf

                    <x-form.input name="name" label="Name" type="text" maxlength="255" :value="old('name')" required />
                    <x-form.input name="email" label="Email" type="email" maxlength="255" :value="old('email')" required />

                    <div class="space-y-1.5">
                        <label for="message" class="block text-sm font-medium text-text">
                            Message <span class="text-danger">*</span>
                        </label>
                        <textarea
                            id="message"
                            name="message"
                            maxlength="2000"
                            required
                            class="input min-h-32 resize-y @error('message') border-danger focus:border-danger focus:ring-red-200 @enderror"
                        >{{ old('message') }}</textarea>
                        @error('message')<p class="mt-1 text-xs font-medium text-danger">{{ $message }}</p>@enderror
                    </div>

                    <x-button type="submit">Send message</x-button>
                </form>
            </x-card>

            <x-card header="Contact information">
                <div class="space-y-4 text-sm text-text-muted">
                    <div>
                        <p class="font-semibold text-text">Address</p>
                        <p class="mt-1">123 Booking Street, Suite 400<br>New York, NY 10001</p>
                    </div>
                    <div>
                        <p class="font-semibold text-text">Email</p>
                        <p class="mt-1">support@booking-saas.test</p>
                    </div>
                    <div>
                        <p class="font-semibold text-text">Phone</p>
                        <p class="mt-1">+1 (555) 123-4567</p>
                    </div>
                    <div>
                        <p class="font-semibold text-text">Working hours</p>
                        <p class="mt-1">Mon - Fri, 9:00 AM - 6:00 PM</p>
                    </div>
                </div>
            </x-card>
        </div>
    </section>
@endsection
