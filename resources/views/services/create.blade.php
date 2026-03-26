@extends('layouts.app')

@section('title', 'New service')

@section('content')
    <div class="mb-8">
        <h1 class="text-h1 text-text">New service</h1>
        <p class="mt-2 text-small text-text-muted">Add a new service with duration, price, and optional image.</p>
    </div>
    <div class="card">
        <div>
        <form action="{{ route('services.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @include('services._form', [
                'service' => null,
                'submitLabel' => 'Create',
                'cancelUrl' => route('services.index'),
            ])
        </form>
        </div>
    </div>
@endsection
