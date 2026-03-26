@extends('layouts.app')

@section('title', 'New service')

@section('content')
    <h1 class="page-title">New service</h1>
    <p class="page-subtitle">Add a new service with duration, price, and optional image.</p>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
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
