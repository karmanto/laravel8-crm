@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">
        <h1>Tambah Chatbot WhatsApp</h1>

        <form action="{{ route('chatbots.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="is_active" class="form-label">Status Aktif:</label>
                <select name="is_active" id="is_active" class="form-select">
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="whatsapp_number" class="form-label">Nomor WhatsApp:</label>
                <input type="text" name="whatsapp_number" id="whatsapp_number" class="form-control" 
                       value="{{ old('whatsapp_number') }}" placeholder="Contoh: 6281234567890" max=15 required>
                @error('whatsapp_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('chatbots.index') }}" class="btn btn-secondary">Back to list</a>
        </form>
    </div>
@endsection
