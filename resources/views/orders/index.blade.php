@extends('layouts.app-master')

@section('content')
<div class="bg-light p-5 rounded">
    <h1>Daftar Order</h1>

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

    <form method="GET" action="{{ route('orders.index') }}">
        <div class="row mb-3">
            <div class="col">
                <select name="customer_id" class="form-control">
                    <option value="">Pilih Customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <a href="{{ route('orders.create') }}" class="btn btn-primary mb-3 mx-2">Add New Order</a>
            </div>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Whatsapp Number</th>
                <th>Awb</th>
                <th>Logistic</th>
                <th>Status</th>
                <th>From</th>
                <th>Total Order</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->customer ? $order->customer->name : '-' }}</td>
                    <td>{{ $order->customer ? $order->customer->whatsapp_number : '-' }}</td>
                    <td>{{ $order->awb ? $order->awb->awb_number : '-' }}</td>
                    <td>{{ $order->awb ? $order->awb->logistic->name : '-' }}</td>
                    <td>{{ $order->status ? $order->status : '-'}}</td>
                    <td>{{ $order->from ? $order->from : '-'}}</td>
                    <td>{{ $order->total_order ? $order->total_order : '-'}}</td>
                    <td>
                        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

    {{-- Menampilkan link pagination --}}
    {{ $orders->links() }}
@endsection
