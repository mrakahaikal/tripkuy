@extends('errors.layout')

@section('title', 'Terjadi Kesalahan')

@section('content')

    <p class="font-display font-extrabold text-[7rem] leading-none text-brand-100 select-none -mb-2">500</p>

    <div class="w-16 h-16 rounded-2xl bg-brand-50 flex items-center justify-center mx-auto mb-5">
        <svg class="w-8 h-8 text-brand-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/>
        </svg>
    </div>

    <h1 class="font-display text-2xl font-bold text-ink mb-2">Terjadi Kesalahan</h1>
    <p class="text-sm text-ink-muted leading-relaxed mb-8">
        Ada sesuatu yang tidak beres di sisi kami. Tim kami sudah diberitahu dan sedang menanganinya.
        Coba lagi dalam beberapa saat.
    </p>

    <div class="flex flex-col sm:flex-row gap-2.5 justify-center">
        <button onclick="window.location.reload()" class="btn btn-primary btn-md">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg>
            Coba Lagi
        </button>
        <a href="{{ route('home') }}" class="btn btn-secondary btn-md">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Ke Beranda
        </a>
    </div>

@endsection
