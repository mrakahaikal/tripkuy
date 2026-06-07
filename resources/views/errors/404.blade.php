@extends('errors.layout')

@section('title', 'Halaman Tidak Ditemukan')

@section('content')

    <p class="font-display font-extrabold text-[7rem] leading-none text-brand-100 select-none -mb-2">404</p>

    <div class="w-16 h-16 rounded-2xl bg-brand-50 flex items-center justify-center mx-auto mb-5">
        <svg class="w-8 h-8 text-brand-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/><path d="M11 8v4"/><path d="M11 16h.01"/>
        </svg>
    </div>

    <h1 class="font-display text-2xl font-bold text-ink mb-2">Halaman Tidak Ditemukan</h1>
    <p class="text-sm text-ink-muted leading-relaxed mb-8">
        Halaman yang kamu cari tidak ada, sudah dipindahkan, atau URL yang kamu masukkan salah.
    </p>

    <div class="flex flex-col sm:flex-row gap-2.5 justify-center">
        <a href="{{ route('home') }}" class="btn btn-primary btn-md">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Kembali ke Beranda
        </a>
        <a href="{{ route('trips.index') }}" class="btn btn-secondary btn-md">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
            Jelajahi Trip
        </a>
    </div>

@endsection
