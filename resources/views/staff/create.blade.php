@extends('layouts.app')

@section('title', 'New staff')

@section('content')
    <h1>New staff</h1>
    <div class="card">
        <form action="{{ route('staff.store') }}" method="post">
            @csrf
            @include('staff._form', [
                'staff' => null,
                'selectedServiceIds' => old('services', []),
                'submitLabel' => 'Create',
                'cancelUrl' => route('staff.index'),
            ])
        </form>
    </div>
@endsection
