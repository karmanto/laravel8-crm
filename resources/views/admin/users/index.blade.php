@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">
        <h1>Daftar Pengguna</h1>

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

        <table class="table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Status Aktif</th>
                    <th>Aksi</th>
                    <th>Jumlah Chatbot WhatsApp</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ($user->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Non-Aktif</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">
                                    {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.users.update-chatbot-whatsapp-count', $user->id) }}" method="POST" class="d-flex">
                                @csrf
                                @method('PUT')
                                <input type="number" name="chatbot_whatsapp_count" value="{{ $user->chatbot_whatsapp_count }}" class="form-control form-control-sm" min="0" id="chatbot_whatsapp_count_{{ $user->id }}" style="max-width: 120px;">
                                <button type="submit" class="btn btn-sm btn-secondary ms-2" id="update_button_{{ $user->id }}" disabled>Update</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        @foreach ($users as $user)
            const originalValue{{ $user->id }} = document.getElementById('chatbot_whatsapp_count_{{ $user->id }}').value;
            const input{{ $user->id }} = document.getElementById('chatbot_whatsapp_count_{{ $user->id }}');
            const button{{ $user->id }} = document.getElementById('update_button_{{ $user->id }}');

            input{{ $user->id }}.addEventListener('input', function() {
                if (input{{ $user->id }}.value !== originalValue{{ $user->id }}) {
                    button{{ $user->id }}.classList.remove('btn-secondary');
                    button{{ $user->id }}.classList.add('btn-warning');
                    button{{ $user->id }}.disabled = false;
                } else {
                    button{{ $user->id }}.classList.remove('btn-warning');
                    button{{ $user->id }}.classList.add('btn-secondary');
                    button{{ $user->id }}.disabled = true;
                }
            });
        @endforeach
    </script>
@endsection
