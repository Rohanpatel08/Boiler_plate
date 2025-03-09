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
        <h1>Test Page</h1>
        <div class="card">
            <div class="card-header">Manage Users</div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush