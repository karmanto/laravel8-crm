@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">
        <h1>Edit Chatbot WhatsApp</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('chatbots.update', $chatbot->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="is_active" class="form-label">Status Aktif:</label>
                <select name="is_active" id="is_active" class="form-select">
                    <option value="1" {{ $chatbot->is_active ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !$chatbot->is_active ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('chatbots.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
