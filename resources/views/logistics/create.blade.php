@extends('layouts.app-master')

@section('content')
<div class="bg-light p-5 rounded">
    <h1>Add New Logistic</h1>

    <form action="{{ route('logistics.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required>
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
