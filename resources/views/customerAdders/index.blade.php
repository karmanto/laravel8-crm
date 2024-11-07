@extends('layouts.app-master')

@section('content')
    <h1>Daftar Customer Adder</h1>
    <h5>otomatis menambahkan data customer berdasarkan pesan</h5>

    <form method="GET" action="{{ route('customerAdders.index') }}">
        <div class="row mb-3">
            <div class="col">
                <a href="{{ route('customerAdders.create') }}" class="btn btn-primary mb-3">Add New Customer Adder</a>
            </div>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Trigger Message</th>
                <th>Trigger From</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customerAdders as $customerAdder)
                <tr>
                    <td>{{ $customerAdder->trigger_message }}</td>
                    <td>{{ $customerAdder->trigger_from ? "Customer" : "User" }}</td>
                    <td>
                        <a href="{{ route('customerAdders.edit', $customerAdder->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('customerAdders.destroy', $customerAdder->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
