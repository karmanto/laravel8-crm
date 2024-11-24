@extends('layouts.app-master')

@section('content')
<div class="bg-light p-5 rounded">
    <h1>Add New Awb</h1>

    <form action="{{ route('awbs.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Awb Number</label>
            <input type="text" name="awb_number" id="awb_number" class="form-control @error('awb_number') is-invalid @enderror" value="{{ old('awb_number') }}" required>
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="customer_id" class="form-label">Customer</label>
            <select name="customer_id" id="customer_id" class="form-control @error('customer_id') is-invalid @enderror">
                <option value="">Pilih Customer</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }}
                    </option>
                @endforeach
            </select>
            @error('customer_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="logistic_id" class="form-label">Logistic</label>
            <select name="logistic_id" id="logistic_id" class="form-control @error('logistic_id') is-invalid @enderror">
                <option value="">Pilih Logistic</option>
                @foreach ($logistics as $logistic)
                    <option value="{{ $logistic->id }}" {{ old('logistic_id') == $logistic->id ? 'selected' : '' }}>
                        {{ $logistic->name }}
                    </option>
                @endforeach
            </select>
            @error('logistic_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">Save</button>
        <a href="{{ route('awbs.index') }}" class="btn btn-secondary mt-3">Back to list</a>
    </form>
</div>
@endsection
