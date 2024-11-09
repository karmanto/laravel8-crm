@extends('layouts.app-master')

@section('content')
<div class="bg-light p-5 rounded">
    <h1>Edit Customer Adder</h1>

    <form action="{{ route('customerAdders.update', $customerAdder->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="trigger_message" class="form-label">Trigger Message</label>
            <input type="text" name="trigger_message" id="trigger_message" class="form-control @error('trigger_message') is-invalid @enderror" value="{{ old('trigger_message', $customerAdder->trigger_message) }}" required>
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
                <option value=0 {{ old('trigger_from', $customerAdder->trigger_from) == 0 ? 'selected' : '' }}>
                    User
                </option>
                <option value=1 {{ old('trigger_from', $customerAdder->trigger_from) == 1 ? 'selected' : '' }}>
                    Customer
                </option>
            </select>
            @error('trigger_from')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('customerAdders.index') }}" class="btn btn-secondary">Back to list</a>
    </form>
</div>
@endsection
