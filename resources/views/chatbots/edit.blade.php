@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">
        <h1>Edit Chatbot WhatsApp</h1>

        <form action="{{ route('chatbots.destroy', $chatbot->id) }}" method="POST" style="margin-bottom:10px;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
        </form>

        <form action="{{ route('chatbots.update', $chatbot->id) }}" method="POST" onsubmit="return confirmWhatsAppChange()">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="is_active" class="form-label">Status Aktif:</label>
                <select name="is_active" id="is_active" class="form-select">
                    <option value="1" {{ $chatbot->is_active ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !$chatbot->is_active ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="whatsapp_number" class="form-label">Nomor WhatsApp:</label>
                <input type="text" name="whatsapp_number" id="whatsapp_number" class="form-control" 
                       value="{{ old('whatsapp_number', $chatbot->whatsapp_number) }}" placeholder="Contoh: 6281234567890" max=15 required>
                @error('whatsapp_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('chatbots.index') }}" class="btn btn-secondary">Back to list</a>
        </form>
    </div>

<script>
    function confirmWhatsAppChange() {
        const newNumber = document.getElementById('whatsapp_number').value;
        const originalNumber = "{{ $chatbot->whatsapp_number }}";
        
        if (newNumber !== originalNumber) {
            return confirm("Mengubah nomor WhatsApp akan membuat customer yang terhubung ke nomor WhatsApp sebelumnya akan menerima pesan dari nomor WhatsApp yang baru. Anda juga harus scan qrcode kembali. Lanjutkan?");
        }
        return true;
    }
</script>
@endsection
