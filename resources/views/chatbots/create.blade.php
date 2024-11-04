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
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('chatbots.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
