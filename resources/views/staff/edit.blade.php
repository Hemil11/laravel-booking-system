@extends('layouts.app')

@section('title', 'Edit staff')

@section('content')
    <h1>Edit staff</h1>
    <div class="card">
        <form action="{{ route('staff.update', $staff) }}" method="post">
            @csrf
            @method('PUT')
            @include('staff._form', [
                'staff' => $staff,
                'selectedServiceIds' => old('services', $staff->services->pluck('id')->all()),
                'submitLabel' => 'Save',
                'cancelUrl' => route('staff.show', $staff),
            ])
        </form>
    </div>
@endsection
