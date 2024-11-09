@extends('layouts.app-master')

@section('content')
<div class="bg-light p-5 rounded">
    <h1>Create Chatbot Schedule</h1>

    <form action="{{ route('chatbot-schedules.store') }}" method="POST" enctype="multipart/form-data">
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
            <label for="trigger_message">Trigger Message</label>
            <textarea name="trigger_message" class="form-control @error('trigger_message') is-invalid @enderror" required>{{ old('trigger_message') }}</textarea>
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
                <option value="0" {{ old('trigger_from') == 0 ? 'selected' : '' }}>User</option>
                <option value="1" {{ old('trigger_from') == 1 ? 'selected' : '' }}>Customer</option>
            </select>
            @error('trigger_from')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="send_after">Send After (seconds)</label>
            <input type="number" name="send_after" class="form-control @error('send_after') is-invalid @enderror" value="{{ old('send_after') }}" required>
            @error('send_after')
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
        <a href="{{ route('chatbot-schedules.index') }}" class="btn btn-secondary">Back to List</a>
    </form>
</div>
@endsection
