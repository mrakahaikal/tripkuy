<x-layouts.auth title="Reset Password — TripKuy">

    {{-- Heading --}}
    <div class="mb-8">
        <div class="w-11 h-11 rounded-xl bg-brand-100 flex items-center justify-center mb-5">
            <x-lucide-lock-keyhole class="w-5 h-5 text-brand-600" />
        </div>
        <h1 class="font-display text-2xl font-bold text-ink mb-2">Buat password baru</h1>
        <p class="text-sm text-ink-muted">Pastikan password baru kamu kuat dan mudah diingat.</p>
    </div>

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
    <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-5">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        {{-- Email (pre-filled from reset link) --}}
        <div>
            <label for="email" class="block text-sm font-semibold text-ink mb-1.5">Alamat Email</label>
            <input
                id="email"
                name="email"
                type="email"
                value="{{ $email ?? old('email') }}"
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

        {{-- Password baru --}}
        <div>
            <label for="password" class="block text-sm font-semibold text-ink mb-1.5">Password Baru</label>
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

        {{-- Konfirmasi --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-ink mb-1.5">Konfirmasi Password Baru</label>
            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                placeholder="Ulangi password baru"
                autocomplete="new-password"
                required
                class="input @error('password_confirmation') border-danger @enderror"
            >
            @error('password_confirmation')
                <p class="text-xs text-danger mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-md w-full justify-center mt-1">
            Reset Password
            <x-lucide-check class="w-4 h-4" />
        </button>
    </form>

</x-layouts.auth>
