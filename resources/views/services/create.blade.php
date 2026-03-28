@extends('layouts.admin')

@section('title', __('New service'))

@section('content')
    <x-admin.form-page
        :title="__('New service')"
        :description="__('Add a bookable service with duration, price, and an optional image.')"
        :back-href="route('services.index')"
        :back-label="__('All services')"
    >
        <x-card :header="__('Service details')">
            <form action="{{ route('services.store') }}" method="post" enctype="multipart/form-data" class="space-y-0">
                @csrf
                @include('services._form', [
                    'service' => null,
                    'submitLabel' => __('Create service'),
                    'cancelUrl' => route('services.index'),
                ])
            </form>
        </x-card>
    </x-admin.form-page>
@endsection
