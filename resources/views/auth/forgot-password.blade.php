<x-layouts.auth title="Lupa Password — TripKuy">

    {{-- Heading --}}
    <div class="mb-8">
        <div class="w-11 h-11 rounded-xl bg-brand-100 flex items-center justify-center mb-5">
            <x-lucide-key-round class="w-5 h-5 text-brand-600" />
        </div>
        <h1 class="font-display text-2xl font-bold text-ink mb-2">Lupa password?</h1>
        <p class="text-sm text-ink-muted leading-relaxed">
            Masukkan alamat email akunmu dan kami akan mengirimkan link untuk mereset password.
        </p>
    </div>

    {{-- Success status --}}
    @if (session('status'))
        <div class="rounded-xl border border-success/30 bg-success/5 px-4 py-3 mb-6">
            <div class="flex items-start gap-2.5">
                <x-lucide-circle-check class="w-4 h-4 text-success shrink-0 mt-0.5" />
                <p class="text-sm text-success font-medium">{{ session('status') }}</p>
            </div>
        </div>
    @endif

    {{-- Validation errors --}}
    @if ($errors->any())
        <div class="rounded-xl border border-danger/30 bg-danger/5 px-4 py-3 mb-6">
            <ul class="text-sm text-danger space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-5">
        @csrf

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

        <button type="submit" class="btn btn-primary btn-md w-full justify-center mt-1">
            Kirim Link Reset
            <x-lucide-send class="w-4 h-4" />
        </button>
    </form>

    <div class="mt-6 text-center">
        <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-sm text-ink-muted hover:text-ink transition-colors">
            <x-lucide-arrow-left class="w-3.5 h-3.5" />
            Kembali ke halaman masuk
        </a>
    </div>

</x-layouts.auth>
