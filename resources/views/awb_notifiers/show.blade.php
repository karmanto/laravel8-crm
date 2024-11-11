@extends('layouts.app-master')

@section('content')
<div class="bg-light p-5 rounded">
    <h1>Awb Notifier Details</h1>

    <div class="card mb-3">
        <div class="card-body">
            <h3 class="card-title">{{ $awbNotifier->name }}</h3>
            <p class="card-text"><strong>Description:</strong> {{ $awbNotifier->description }}</p>
            <p class="card-text"><strong>Message:</strong> {{ $awbNotifier->message }}</p>
            <p class="card-text"><strong>Trigger Awb Status:</strong> {{ $awbNotifier->trigger_awb_status }}</p>
            <p class="card-text"><strong>Logistic:</strong> {{ $awbNotifier->logistic->name }}</p>
        </div>
    </div>

    <h4>Documents</h4>
    @if($awbNotifier->documents->isNotEmpty())
        <div class="row">
            @foreach($awbNotifier->documents as $document)
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
        <p>No documents uploaded for this notifier.</p>
    @endif

    <a href="{{ route('awb-notifiers.index') }}" class="btn btn-secondary">Back to List</a>
    <a href="{{ route('awb-notifiers.edit', $awbNotifier) }}" class="btn btn-primary">Edit</a>
    <form action="{{ route('awb-notifiers.destroy', $awbNotifier) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this notifier?')">Delete</button>
    </form>
</div>
@endsection
