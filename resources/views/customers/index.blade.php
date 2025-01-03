@extends('layouts.app-master')

@section('content')
<div class="bg-light p-5 rounded">
    <h1>Daftar Customer</h1>

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

    <form method="GET" action="{{ route('customers.index') }}">
        <div class="row mb-3">
            <div class="col-md-8">
                <input type="text" name="search" class="form-control" placeholder="Cari nama atau nomor WhatsApp..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <a href="{{ route('customers.create') }}" class="btn btn-primary mb-3">Add New Customer</a>
            </div>
        </div>
    </form>
    

    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Nomor WhatsApp</th>
                <th>Umur</th>
                <th>Alamat</th>
                <th>Is Exception</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->whatsapp_number }}</td>
                    <td>{{ $customer->age ? $customer->age : '-' }}</td>
                    <td>{{ $customer->address ? $customer->address : '-' }}</td>
                    <td>{{ $customer->is_exception ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <a href="{{ route('orders.index', ['customer_id' => $customer->id]) }}" class="btn btn-sm btn-info">View Order</a>
                        <a href="{{ route('orders.create', ['customer_id' => $customer->id]) }}" class="btn btn-sm btn-success">Create Order</a>
                        <a href="{{ route('awbs.index', ['customer_id' => $customer->id]) }}" class="btn btn-sm btn-primary">View AWB</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

    {{-- Menampilkan link pagination --}}
    {{ $customers->links() }}
@endsection
