@extends('layouts.app-master')

@section('content')
<div class="bg-light p-5 rounded">
    <h1>Daftar Logistics</h1>
    @if(auth()->user()->is_admin)
        <a href="{{ route('logistics.create') }}" class="btn btn-primary mb-3">Add New Logistic</a>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logistics as $logistic)
                <tr>
                    <td>{{ $logistic->id }}</td>
                    <td>{{ $logistic->name }}</td>
                    <td>
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('logistics.edit', $logistic->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
