@extends('layouts.app')

@section('title', 'New service')

@section('content')
    <h1>New service</h1>
    <div class="card">
        <form action="{{ route('services.store') }}" method="post">
            @csrf
            @include('services._form', [
                'service' => null,
                'submitLabel' => 'Create',
                'cancelUrl' => route('services.index'),
            ])
        </form>
    </div>
@endsection
