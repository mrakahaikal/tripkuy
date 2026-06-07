@extends('errors.layout')

@section('title', 'Akses Ditolak')

@section('content')

    <p class="font-display font-extrabold text-[7rem] leading-none text-brand-100 select-none -mb-2">403</p>

    <div class="w-16 h-16 rounded-2xl bg-brand-50 flex items-center justify-center mx-auto mb-5">
        <svg class="w-8 h-8 text-brand-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
        </svg>
    </div>

    <h1 class="font-display text-2xl font-bold text-ink mb-2">Akses Ditolak</h1>
    <p class="text-sm text-ink-muted leading-relaxed mb-3">
        Kamu tidak memiliki izin untuk mengakses halaman ini.
    </p>

    @if($exception->getMessage())
        <p class="text-xs text-ink-muted bg-surface-sunken rounded-lg px-3 py-2 mb-8 font-mono">
            {{ $exception->getMessage() }}
        </p>
    @else
        <div class="mb-8"></div>
    @endif

    <div class="flex flex-col sm:flex-row gap-2.5 justify-center">
        @auth
            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-md">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                Ke Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary btn-md">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
                Masuk Dulu
            </a>
        @endauth
        <a href="{{ route('home') }}" class="btn btn-secondary btn-md">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Ke Beranda
        </a>
    </div>

@endsection
