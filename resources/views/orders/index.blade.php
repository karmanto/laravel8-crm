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
