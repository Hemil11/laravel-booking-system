@extends('layouts.app')

@section('title', 'Edit service')

@section('content')
    <h1>Edit service</h1>
    <div class="card">
        <form action="{{ route('services.update', $service) }}" method="post">
            @csrf
            @method('PUT')
            @include('services._form', [
                'service' => $service,
                'submitLabel' => 'Save',
                'cancelUrl' => route('services.show', $service),
            ])
        </form>
    </div>
@endsection
