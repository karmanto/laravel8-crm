@extends('layouts.app-master')

@section('content')
<div class="bg-light p-5 rounded">
    <h1>Edit Chatbot Schedule</h1>

    <form action="{{ route('chatbot-schedules.update', $chatbotSchedule->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $chatbotSchedule->name) }}" required>
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description">Description</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $chatbotSchedule->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="message">Message</label>
            <textarea name="message" class="form-control @error('message') is-invalid @enderror" required>{{ old('message', $chatbotSchedule->message) }}</textarea>
            @error('message')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="trigger_message">Trigger Message</label>
            <textarea name="trigger_message" class="form-control @error('trigger_message') is-invalid @enderror" required>{{ old('trigger_message', $chatbotSchedule->trigger_message) }}</textarea>
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
                <option value="0" {{ old('trigger_from', $chatbotSchedule->trigger_from) == 0 ? 'selected' : '' }}>User</option>
                <option value="1" {{ old('trigger_from', $chatbotSchedule->trigger_from) == 1 ? 'selected' : '' }}>Customer</option>
            </select>
            @error('trigger_from')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="send_after">Send After</label>
            <div class="row">
                <div class="col-3">
                    <input type="number" id="days" class="form-control" placeholder="Days" value="{{ floor($chatbotSchedule->send_after / 86400) }}">
                </div>
                <div class="col-3">
                    <input type="number" id="hours" class="form-control" placeholder="Hours" max="23" value="{{ floor(($chatbotSchedule->send_after % 86400) / 3600) }}">
                </div>
                <div class="col-3">
                    <input type="number" id="minutes" class="form-control" placeholder="Minutes" max="59" value="{{ floor(($chatbotSchedule->send_after % 3600) / 60) }}">
                </div>
                <div class="col-3">
                    <input type="number" id="seconds" class="form-control" placeholder="Seconds" max="59" value="{{ $chatbotSchedule->send_after % 60 }}">
                </div>
            </div>
            <input type="hidden" name="send_after" id="send_after" class="form-control" value="{{ $chatbotSchedule->send_after }}">
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

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('chatbot-schedules.index') }}" class="btn btn-secondary">Back to List</a>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const daysInput = document.getElementById('days');
        const hoursInput = document.getElementById('hours');
        const minutesInput = document.getElementById('minutes');
        const secondsInput = document.getElementById('seconds');
        const sendAfterInput = document.getElementById('send_after');

        function calculateTotalSeconds() {
            const days = parseInt(daysInput.value) || 0;
            const hours = parseInt(hoursInput.value) || 0;
            const minutes = parseInt(minutesInput.value) || 0;
            const seconds = parseInt(secondsInput.value) || 0;

            const totalSeconds = (days * 86400) + (hours * 3600) + (minutes * 60) + seconds;
            sendAfterInput.value = totalSeconds;
        }

        [daysInput, hoursInput, minutesInput, secondsInput].forEach(input => {
            input.addEventListener('input', calculateTotalSeconds);
        });
    });
</script>
@endsection
