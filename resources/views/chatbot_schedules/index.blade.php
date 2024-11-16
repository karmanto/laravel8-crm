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
                    <td>{{ $chatbotSchedule->formatted_send_after }}</td>
                    <td>
                        <div class="d-flex align-items-stretch">
                            <a href="{{ route('chatbot-schedules.show', $chatbotSchedule->id) }}" class="btn btn-info btn-sm me-2 flex-fill">View</a>
                            <a href="{{ route('chatbot-schedules.edit', $chatbotSchedule->id) }}" class="btn btn-warning btn-sm me-2 flex-fill">Edit</a>
                            <form action="{{ route('chatbot-schedules.destroy', $chatbotSchedule->id) }}" method="POST" class="flex-fill">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm w-100 h-100" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    </td>                                     
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
