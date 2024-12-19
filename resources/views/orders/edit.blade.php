@extends('layouts.app-master')

@section('content')
<div class="bg-light p-5 rounded">
    <h1>Edit Order</h1>

    <form action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="customer_id" class="form-label">Customer</label>
            <select name="customer_id" id="customer_id" class="form-control @error('customer_id') is-invalid @enderror">
                <option value="">Pilih Customer</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}" {{ old('customer_id', $order->customer_id) == $customer->id ? 'selected' : '' }}>
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
            <label for="status" class="form-label">Status</label>
            <input type="text" name="status" id="status" class="form-control @error('status') is-invalid @enderror" value="{{ old('status', $order->status) }}">
            @error('status')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="from" class="form-label">From</label>
            <input type="text" name="from" id="from" class="form-control @error('from') is-invalid @enderror" value="{{ old('from', $order->from) }}">
            @error('from')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="total_order" class="form-label">Total Order</label>
            <input type="number" name="total_order" id="total_order" class="form-control @error('total_order') is-invalid @enderror" value="{{ old('total_order', $order->total_order) }}">
            @error('total_order')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        @if ($order->awb)
            <!-- AWB Number and Logistic always shown if already exists -->
            <div class="mb-3">
                <label for="awb_number" class="form-label">AWB Number</label>
                <input type="text" name="awb_number" id="awb_number" class="form-control @error('awb_number') is-invalid @enderror" value="{{ old('awb_number', $order->awb->awb_number) }}">
                @error('awb_number')
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
                        <option value="{{ $logistic->id }}" {{ old('logistic_id', $order->awb->logistic_id) == $logistic->id ? 'selected' : '' }}>
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
        @else
            <!-- Checkbox to toggle AWB Number and Logistic -->
            <div class="mb-3">
                <input type="checkbox" id="toggle_awb_logistic" class="form-check-input" 
                       onclick="toggleAwbLogistic()" 
                       {{ old('awb_number') || old('logistic_id') ? 'checked' : '' }}>
                <label for="toggle_awb_logistic" class="form-check-label">Add AWB</label>
            </div>

            <div id="awb_logistic_section" style="{{ old('awb_number') || old('logistic_id') ? 'display:block;' : 'display:none;' }}">
                <div class="mb-3">
                    <label for="awb_number" class="form-label">AWB Number</label>
                    <input type="text" name="awb_number" id="awb_number" class="form-control @error('awb_number') is-invalid @enderror" value="{{ old('awb_number') }}">
                    @error('awb_number')
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
            </div>
        @endif

        <button type="submit" class="btn btn-primary mt-3">Update</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">Back to list</a>
    </form>
</div>

<script>
    function toggleAwbLogistic() {
        var awbLogisticSection = document.getElementById('awb_logistic_section');
        awbLogisticSection.style.display = document.getElementById('toggle_awb_logistic').checked ? 'block' : 'none';
    }
</script>
@endsection
