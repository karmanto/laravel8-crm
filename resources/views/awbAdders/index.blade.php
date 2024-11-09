@extends('layouts.app-master')

@section('content')
<div class="bg-light p-5 rounded">
    <h1>Daftar Awb Adder</h1>

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

    <a href="{{ route('awbAdders.create') }}" class="btn btn-primary mb-3">Add New Awb Adder</a>

    <table class="table">
        <thead>
            <tr>
                <th>Trigger Message</th>
                <th>Trigger From</th>
                <th>Awb Field</th>
                <th>Logistic Field</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($awbAdders as $awbAdder)
                <tr>
                    <td>{{ $awbAdder->trigger_message }}</td>
                    <td>{{ $awbAdder->trigger_from ? "Customer" : "User" }}</td>
                    <td>{{ $awbAdder->awb_field }}</td>
                    <td>{{ $awbAdder->logistic_field }}</td>
                    <td>
                        <a href="{{ route('awbAdders.edit', $awbAdder->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('awbAdders.destroy', $awbAdder->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
