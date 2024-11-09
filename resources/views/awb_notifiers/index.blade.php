@extends('layouts.app-master')

@section('content')
<div class="bg-light p-5 rounded">
    <h1>Awb Notifiers</h1>
    
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

    <a href="{{ route('awb-notifiers.create') }}" class="btn btn-primary mb-3">Tambah Awb Notifier</a>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Message</th>
                <th>Trigger Awb Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($awbNotifiers as $awbNotifier)
                <tr>
                    <td>{{ $awbNotifier->name }}</td>
                    <td>{{ $awbNotifier->description }}</td>
                    <td>{{ $awbNotifier->message }}</td>
                    <td>{{ $awbNotifier->trigger_awb_status }}</td>
                    <td>
                        <a href="{{ route('awb-notifiers.show', $awbNotifier->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('awb-notifiers.edit', $awbNotifier->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('awb-notifiers.destroy', $awbNotifier->id) }}" method="POST" style="display:inline;">
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
