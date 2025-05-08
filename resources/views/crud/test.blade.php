@extends('layouts.app')

@push('styles')
    <style>
        .container {
            background-color: rgb(100, 233, 243);
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between">
            <h1>Test Page</h1>
            <a href="{{ route('test.create') }}" class="btn btn-primary">Add User</a>
        </div>
        <div class="card">
            <div class="card-header bg-secondary">Manage Users</div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush