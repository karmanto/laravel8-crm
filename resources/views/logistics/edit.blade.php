@extends('layouts.app-master')

@section('content')
<div class="bg-light p-5 rounded">
    <h1>Edit Logistic</h1>

    <form action="{{ route('logistics.destroy', $logistic->id) }}" method="POST" style="margin-bottom:10px;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
    </form>

    <form action="{{ route('logistics.update', $logistic->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $logistic->name) }}" required>
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
