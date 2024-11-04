@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">
        <h1>Aplikasi CRM Ala-Ala, fitur suka-suka.</h1>

        @auth
        {{-- Menambahkan konten jika user aktif dan bukan admin --}}
        @if (auth()->user()->is_active && !auth()->user()->is_admin)
            <p class="lead">Selamat datang, {{auth()->user()->username}}.</p>
        @elseif (auth()->user()->is_active && auth()->user()->is_admin)
            {{-- Menambahkan konten jika user adalah admin dan aktif --}}
            <p class="lead">Selamat datang Admin.</p>
        @else
            {{-- Menambahkan konten jika user tidak aktif --}}
            <p class="lead">Akunmu belum aktif, hubungi admin dulu, ya.</p>

        @endif
        @endauth

        @guest
        <p>Silahkan login atau sign up untuk memulai.</p>
        @endguest
    </div>
@endsection
