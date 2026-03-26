@extends('layouts.app')

@section('title', 'Edit service')

@section('content')
    <div class="mb-8">
        <h1 class="text-h1 text-text">Edit service</h1>
        <p class="mt-2 text-small text-text-muted">Update service details and media.</p>
    </div>
    <div class="card">
        <div>
        <form action="{{ route('services.update', $service) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('services._form', [
                'service' => $service,
                'submitLabel' => 'Save',
                'cancelUrl' => route('services.show', $service),
            ])
        </form>
        </div>
    </div>
@endsection
