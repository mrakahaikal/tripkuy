<x-layouts.auth title="Masuk — TripKuy">

    {{-- Heading --}}
    <div class="mb-8">
        <h1 class="font-display text-2xl font-bold text-ink mb-1">Selamat datang kembali</h1>
        <p class="text-sm text-ink-muted">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-brand-600 font-medium hover:underline">Daftar gratis</a>
        </p>
    </div>

    {{-- Session status (e.g. "Link reset telah dikirim") --}}
    @if (session('status'))
        <div class="rounded-xl border border-success/30 bg-success/5 px-4 py-3 mb-6">
            <p class="text-sm text-success font-medium">{{ session('status') }}</p>
        </div>
    @endif

    {{-- Validation errors --}}
    @if ($errors->any())
        <div class="rounded-xl border border-danger/30 bg-danger/5 px-4 py-3 mb-6">
            <p class="text-sm font-semibold text-danger mb-1">Terdapat kesalahan:</p>
            <ul class="list-disc list-inside text-sm text-danger/80 space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-5">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-semibold text-ink mb-1.5">Alamat Email</label>
            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                placeholder="kamu@email.com"
                autocomplete="email"
                required
                autofocus
                class="input @error('email') border-danger @enderror"
            >
            @error('email')
                <p class="text-xs text-danger mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="text-sm font-semibold text-ink">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-brand-600 hover:underline">Lupa password?</a>
                @endif
            </div>
            <input
                id="password"
                name="password"
                type="password"
                placeholder="Password kamu"
                autocomplete="current-password"
                required
                class="input @error('password') border-danger @enderror"
            >
            @error('password')
                <p class="text-xs text-danger mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember me --}}
        <div class="flex items-center gap-2.5">
            <input
                id="remember"
                name="remember"
                type="checkbox"
                class="w-4 h-4 rounded accent-brand-600"
            >
            <label for="remember" class="text-sm text-ink-secondary cursor-pointer select-none">Ingat saya di perangkat ini</label>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-primary btn-md w-full justify-center mt-1">
            Masuk
            <x-lucide-arrow-right class="w-4 h-4" />
        </button>
    </form>

</x-layouts.auth>
