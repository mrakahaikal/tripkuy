<x-layouts.auth title="Daftar — TripKuy">

    {{-- Heading --}}
    <div class="mb-8">
        <h1 class="font-display text-2xl font-bold text-ink mb-1">Buat akun baru</h1>
        <p class="text-sm text-ink-muted">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-brand-600 font-medium hover:underline">Masuk sekarang</a>
        </p>
    </div>

    {{-- Global errors --}}
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
    <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-5">
        @csrf

        {{-- Nama Lengkap --}}
        <div>
            <label for="name" class="block text-sm font-semibold text-ink mb-1.5">Nama Lengkap</label>
            <input
                id="name"
                name="name"
                type="text"
                value="{{ old('name') }}"
                placeholder="Contoh: Budi Santoso"
                autocomplete="name"
                required
                autofocus
                class="input @error('name') border-danger @enderror"
            >
            @error('name')
                <p class="text-xs text-danger mt-1.5">{{ $message }}</p>
            @enderror
        </div>

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
                class="input @error('email') border-danger @enderror"
            >
            @error('email')
                <p class="text-xs text-danger mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-semibold text-ink mb-1.5">Password</label>
            <input
                id="password"
                name="password"
                type="password"
                placeholder="Minimal 8 karakter"
                autocomplete="new-password"
                required
                class="input @error('password') border-danger @enderror"
            >
            @error('password')
                <p class="text-xs text-danger mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-ink mb-1.5">Konfirmasi Password</label>
            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                placeholder="Ulangi password"
                autocomplete="new-password"
                required
                class="input @error('password_confirmation') border-danger @enderror"
            >
            @error('password_confirmation')
                <p class="text-xs text-danger mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-primary btn-md w-full justify-center mt-1">
            Daftar Gratis
            <x-lucide-arrow-right class="w-4 h-4" />
        </button>
    </form>

    {{-- Terms --}}
    <p class="text-xs text-ink-muted text-center mt-5 leading-relaxed">
        Dengan mendaftar, kamu menyetujui
        <a href="#" class="text-brand-600 hover:underline">Syarat & Ketentuan</a>
        serta
        <a href="#" class="text-brand-600 hover:underline">Kebijakan Privasi</a>
        kami.
    </p>

</x-layouts.auth>
