@extends('layouts.app-master')

@section('content')
<div class="bg-light p-5 rounded">
    <h1>Create Awb Notifier</h1>

    <form action="{{ route('awb-notifiers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description">Description</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="message">Message</label>
            <textarea name="message" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
            @error('message')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="trigger_awb_status">Trigger Awb Status</label>
            <textarea name="trigger_awb_status" class="form-control @error('trigger_awb_status') is-invalid @enderror" required>{{ old('trigger_awb_status') }}</textarea>
            @error('trigger_awb_status')
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

        <div class="mb-3">
            <label for="documents">Documents</label>
            <input type="file" name="documents[]" class="form-control @error('documents.*') is-invalid @enderror" multiple>
            <small class="form-text text-muted">You can upload multiple image less than 2MB (e.g., .jpg, .jpeg, .png).</small>
            @error('documents.*')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('awb-notifiers.index') }}" class="btn btn-secondary">Back to List</a>
    </form>
</div>
@endsection
