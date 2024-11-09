@extends('layouts.app-master')

@section('content')
<div class="bg-light p-5 rounded">
    <h1>Chatbot Schedule Details</h1>

    <div class="card mb-3">
        <div class="card-body">
            <h3 class="card-title">{{ $chatbotSchedule->name }}</h3>
            <p class="card-text"><strong>Description:</strong> {{ $chatbotSchedule->description }}</p>
            <p class="card-text"><strong>Message:</strong> {{ $chatbotSchedule->message }}</p>
            <p class="card-text"><strong>Trigger Message:</strong> {{ $chatbotSchedule->trigger_message }}</p>
            <p class="card-text"><strong>Trigger From:</strong> {{ $chatbotSchedule->trigger_from == 0 ? 'User' : 'Customer' }}</p>
            <p class="card-text"><strong>Send After (seconds):</strong> {{ $chatbotSchedule->send_after }}</p>
        </div>
    </div>

    <h4>Documents</h4>
    @if($chatbotSchedule->documents->isNotEmpty())
        <div class="row">
            @foreach($chatbotSchedule->documents as $document)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <p>{{ $document->name }}</p>
                            <a href="{{ asset('storage/' . str_replace('public/', '', $document->filepath)) }}" target="_blank">
                                <img src="{{ asset('storage/' . str_replace('public/', '', $document->filepath)) }}" alt="{{ $document->name }}" class="img-fluid" style="max-height: 200px;">
                            </a>                            
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No documents uploaded for this schedule.</p>
    @endif

    <a href="{{ route('chatbot-schedules.index') }}" class="btn btn-secondary">Back to List</a>
    <a href="{{ route('chatbot-schedules.edit', $chatbotSchedule) }}" class="btn btn-primary">Edit</a>
    <form action="{{ route('chatbot-schedules.destroy', $chatbotSchedule) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this schedule?')">Delete</button>
    </form>
</div>
@endsection
