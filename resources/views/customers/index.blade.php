@extends('layouts.app-master')

@section('content')
    <h1>Daftar Customer</h1>

    <form method="GET" action="{{ route('customers.index') }}">
        <div class="row mb-3">
            <div class="col">
                <select name="chatbot_whatsapp_id" class="form-control">
                    <option value="">Pilih Chatbot</option>
                    @foreach ($chatbots as $chatbot)
                        <option value="{{ $chatbot->id }}" {{ request('chatbot_whatsapp_id') == $chatbot->id ? 'selected' : '' }}>
                            {{ $chatbot->whatsapp_number }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <select name="chatbot_schedule_id" class="form-control">
                    <option value="">Pilih Schedule</option>
                    @foreach ($schedules as $schedule)
                        <option value="{{ $schedule->id }}" {{ request('chatbot_schedule_id') == $schedule->id ? 'selected' : '' }}>
                            {{ $schedule->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <select name="is_exception" class="form-control">
                    <option value="">Pilih Exception</option>
                    <option value="1" {{ request('is_exception') === '1' ? 'selected' : '' }}>Exception</option>
                    <option value="0" {{ request('is_exception') === '0' ? 'selected' : '' }}>Non-Exception</option>
                </select>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <a href="{{ route('customers.create') }}" class="btn btn-primary mb-3">Add New Customer</a>
                <a href="{{ route('customerAdders.index') }}" class="btn btn-primary mb-3 mx-4">Ke Halaman Customer Adder</a>
            </div>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Nomor WhatsApp</th>
                <th>Chatbot WhatsApp Number</th>
                <th>Chatbot Schedule</th>
                <th>Is Exception</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->whatsapp_number }}</td>
                    <td>{{ $customer->chatbotWhatsapp ? $customer->chatbotWhatsapp->whatsapp_number : '-' }}</td>
                    <td>{{ $customer->chatbotSchedule ? $customer->chatbotSchedule->name : '-' }}</td>
                    <td>{{ $customer->is_exception ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Menampilkan link pagination --}}
    {{ $customers->links() }}
@endsection
