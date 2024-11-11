@extends('layouts.app-master')

@section('content')
<div class="bg-light p-5 rounded">
    <h1>Add New Customer</h1>

    <form action="{{ route('customers.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="whatsapp_number" class="form-label">Nomor WhatsApp</label>
            <input type="text" name="whatsapp_number" id="whatsapp_number" class="form-control @error('whatsapp_number') is-invalid @enderror" value="{{ old('whatsapp_number') }}" required>
            @error('whatsapp_number')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="chatbot_whatsapp_id" class="form-label">Chatbot WhatsApp</label>
            <select name="chatbot_whatsapp_id" id="chatbot_whatsapp_id" class="form-control @error('chatbot_whatsapp_id') is-invalid @enderror">
                <option value="">Pilih Chatbot</option>
                @foreach ($chatbots as $chatbot)
                    <option value="{{ $chatbot->id }}" {{ old('chatbot_whatsapp_id') == $chatbot->id ? 'selected' : '' }}>
                        {{ $chatbot->whatsapp_number }}
                    </option>
                @endforeach
            </select>
            @error('chatbot_whatsapp_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="chatbot_schedule_id" class="form-label">Chatbot Schedule</label>
            <select name="chatbot_schedule_id" id="chatbot_schedule_id" class="form-control @error('chatbot_schedule_id') is-invalid @enderror">
                <option value="">Pilih Schedule</option>
                @foreach ($schedules as $schedule)
                    <option value="{{ $schedule->id }}" {{ old('chatbot_schedule_id') == $schedule->id ? 'selected' : '' }}>
                        {{ $schedule->name }}
                    </option>
                @endforeach
            </select>
            @error('chatbot_schedule_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_exception" id="is_exception" value="1" {{ old('is_exception') ? 'checked' : '' }}>
            <label class="form-check-label" for="is_exception">Is Exception</label>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Save</button>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary mt-3">Back to list</a>
    </form>
</div>
@endsection
