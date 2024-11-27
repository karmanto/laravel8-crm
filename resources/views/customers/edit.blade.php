@extends('layouts.app-master')

@section('content')
<div class="bg-light p-5 rounded">
    <h1>Edit Customer</h1>

    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="margin-bottom:10px;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
    </form>

    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $customer->name) }}" required>
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="whatsapp_number" class="form-label">Nomor WhatsApp</label>
            <input type="text" name="whatsapp_number" id="whatsapp_number" class="form-control @error('whatsapp_number') is-invalid @enderror" value="{{ old('whatsapp_number', $customer->whatsapp_number) }}" required>
            @error('whatsapp_number')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="age" class="form-label">Umur</label>
            <input type="number" name="age" id="age" class="form-control @error('age') is-invalid @enderror" value="{{ old('age', $customer->age) }}" min=5 max=100>
            @error('age')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Alamat</label>
            <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $customer->address) }}"></textarea>
            @error('address')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-check">
            <input type="hidden" name="is_exception" value="0">
            <input class="form-check-input" type="checkbox" name="is_exception" id="is_exception" value="1" {{ old('is_exception', $customer->is_exception) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_exception">Is Exception</label>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update</button>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary mt-3">Back to list</a>
    </form>
</div>
@endsection
