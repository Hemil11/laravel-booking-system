@extends('layouts.admin')

@section('title', __('Edit service'))

@section('content')
    <x-admin.form-page
        :title="__('Edit service')"
        :description="__('Update how this service appears to customers and staff.')"
        :back-href="route('services.index')"
        :back-label="__('All services')"
    >
        <x-card :header="__('Service details')">
            <form action="{{ route('services.update', $service) }}" method="post" enctype="multipart/form-data" class="space-y-0">
                @csrf
                @method('PUT')
                @include('services._form', [
                    'service' => $service,
                    'submitLabel' => __('Save changes'),
                    'cancelUrl' => route('services.index'),
                ])
            </form>
        </x-card>
    </x-admin.form-page>
@endsection
