@extends('layouts.app-master')

@section('content')
<div class="bg-light p-5 rounded">
    <h1>Daftar Awb</h1>

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

    <form method="GET" action="{{ route('awbs.index') }}">
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
                <select name="logistic_id" class="form-control">
                    <option value="">Pilih Logistic</option>
                    @foreach ($logistics as $logistic)
                        <option value="{{ $logistic->id }}" {{ request('logistic_id') == $logistic->id ? 'selected' : '' }}>
                            {{ $logistic->name }}
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
                <a href="{{ route('awbs.create') }}" class="btn btn-primary mb-3 mx-2">Add New Awb</a>
            </div>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Awb Number</th>
                <th>Customer</th>
                <th>Logistic</th>
                <th>Last Awb Status</th>
                <th>Last Awb Status Date</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($awbs as $awb)
                <tr>
                    <td>{{ $awb->awb_number }}</td>
                    <td>{{ $awb->customer ? $awb->customer->name : '-' }}</td>
                    <td>{{ $awb->logistic ? $awb->logistic->name : '-' }}</td>
                    <td>{{ $awb->last_awb_status ? $awb->last_awb_status : '-'}}</td>
                    <td>{{ $awb->last_awb_status_date ? $awb->last_awb_status_date : '-'}}</td>
                    <td>
                        <a href="{{ route('awbs.edit', $awb->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

    {{-- Menampilkan link pagination --}}
    {{ $awbs->links() }}
@endsection
