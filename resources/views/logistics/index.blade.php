@extends('layouts.app-master')

@section('content')
<div class="bg-light p-5 rounded">
    <h1>Daftar Logistics</h1>
    @if(auth()->user()->is_admin)
        <a href="{{ route('logistics.create') }}" class="btn btn-primary mb-3">Add New Logistic</a>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logistics as $logistic)
                <tr>
                    <td>{{ $logistic->id }}</td>
                    <td>{{ $logistic->name }}</td>
                    <td>
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('logistics.edit', $logistic->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('logistics.destroy', $logistic->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
