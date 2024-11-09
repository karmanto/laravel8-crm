@extends('layouts.app-master')

@section('content')
<div class="bg-light p-5 rounded">
    <h1>Add New Awb Adder</h1>

    <form action="{{ route('awbAdders.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="trigger_message" class="form-label">Trigger Message</label>
            <input type="text" name="trigger_message" id="trigger_message" class="form-control @error('trigger_message') is-invalid @enderror" value="{{ old('trigger_message') }}" required>
            @error('trigger_message')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="trigger_from" class="form-label">Trigger From</label>
            <select name="trigger_from" id="trigger_from" class="form-control @error('trigger_from') is-invalid @enderror">
                <option value="">Pilih Trigger Form</option>
                <option value=0 {{ old('trigger_from') == 0 ? 'selected' : '' }}>
                    User
                </option>
                <option value=1 {{ old('trigger_from') == 1 ? 'selected' : '' }}>
                    Customer
                </option>
            </select>
            @error('trigger_from')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="awb_field" class="form-label">Awb Field</label>
            <input type="text" name="awb_field" id="awb_field" class="form-control @error('awb_field') is-invalid @enderror" value="{{ old('awb_field') }}" required>
            @error('awb_field')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="logistic_field" class="form-label">Logistic Field</label>
            <input type="text" name="logistic_field" id="logistic_field" class="form-control @error('logistic_field') is-invalid @enderror" value="{{ old('logistic_field') }}" required>
            @error('logistic_field')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('awbAdders.index') }}" class="btn btn-secondary">Back to list</a>
    </form>
</div>
@endsection
