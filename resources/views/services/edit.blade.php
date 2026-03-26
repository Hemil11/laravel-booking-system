@extends('layouts.app')

@section('title', 'Edit service')

@section('content')
    <h1 class="page-title">Edit service</h1>
    <p class="page-subtitle">Update service details and media.</p>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
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
