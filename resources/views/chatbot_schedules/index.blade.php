@extends('layouts.app-master')

@section('content')
<div class="bg-light p-5 rounded">
    <h1>Daftar Chatbot Schedules</h1>
    
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

    <a href="{{ route('chatbot-schedules.create') }}" class="btn btn-primary mb-3">Tambah Chatbot Schedule</a>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Message</th>
                <th>Trigger Message</th>
                <th>Trigger From</th>
                <th>Send After</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($chatbotSchedules as $chatbotSchedule)
                <tr>
                    <td>{{ $chatbotSchedule->name }}</td>
                    <td>{{ $chatbotSchedule->description }}</td>
                    <td>{{ $chatbotSchedule->message }}</td>
                    <td>{{ $chatbotSchedule->trigger_message }}</td>
                    <td>{{ $chatbotSchedule->trigger_from ? "Customer" : "User" }}</td>
                    <td>{{ $chatbotSchedule->send_after }}</td>
                    <td>
                        <a href="{{ route('chatbot-schedules.show', $chatbotSchedule->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('chatbot-schedules.edit', $chatbotSchedule->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('chatbot-schedules.destroy', $chatbotSchedule->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
