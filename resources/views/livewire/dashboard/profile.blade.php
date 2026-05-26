<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public string $name  = '';
    public string $email = '';
    public string $phone = '';
    public $photo        = null;

    public bool $saved = false;

    public function mount(): void
    {
        $user        = auth()->user();
        $this->name  = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
    }

    public function updatedPhoto(): void
    {
        $this->validateOnly('photo', [
            'photo' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }

    public function savePhoto(): void
    {
        $this->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = auth()->user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => $this->photo->store('avatars', 'public')]);

        $this->photo = null;
    }

    public function removePhoto(): void
    {
        $user = auth()->user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
        }
    }

    public function save(): void
    {
        $this->validate([
            'name'  => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore(auth()->id())],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        auth()->user()->update([
            'name'  => $this->name,
            'email' => $this->email,
            'phone' => $this->phone ?: null,
        ]);

        $this->saved = true;
    }

    public function updatedName(): void { $this->saved = false; }

    public function updatedEmail(): void { $this->saved = false; }

    public function updatedPhone(): void { $this->saved = false; }
}; ?>

<div class="space-y-6">

    {{-- Page header --}}
    <div>
        <h1 class="font-display text-xl font-bold text-ink">Profil & Akun</h1>
        <p class="text-sm text-ink-muted mt-0.5">Kelola informasi pribadi dan keamanan akunmu.</p>
    </div>

    {{-- Profile info card --}}
    <div class="bg-white border border-border rounded-2xl overflow-hidden">
        <div class="px-5 py-4 border-b border-border">
            <h2 class="font-display font-bold text-ink text-[0.9375rem]">Informasi Pribadi</h2>
        </div>
        <div class="px-5 py-5 flex items-start gap-5">

            {{-- Avatar --}}
            <div class="shrink-0 flex flex-col items-center gap-2">
                <div class="relative group">
                    {{-- Display: preview, current avatar, or initials --}}
                    @if($photo)
                        <img src="{{ $photo->temporaryUrl() }}"
                             class="w-16 h-16 rounded-full object-cover ring-2 ring-brand-400 ring-offset-2">
                    @elseif(auth()->user()->avatar_url)
                        <img src="{{ auth()->user()->avatar_url }}"
                             alt="{{ auth()->user()->name }}"
                             class="w-16 h-16 rounded-full object-cover">
                    @else
                        <div class="w-16 h-16 rounded-full bg-brand-100 flex items-center justify-center">
                            <span class="text-2xl font-bold text-brand-600">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                        </div>
                    @endif

                    {{-- Camera overlay --}}
                    <label class="absolute inset-0 rounded-full bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                        <x-lucide-camera class="w-5 h-5 text-white" />
                        <input type="file" wire:model="photo" accept="image/jpeg,image/png,image/webp" class="sr-only">
                    </label>
                </div>

                {{-- Loading indicator while uploading --}}
                <div wire:loading wire:target="photo" class="text-xs text-ink-muted flex items-center gap-1">
                    <svg class="w-3 h-3 animate-spin" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                    </svg>
                    Memuat…
                </div>

                @error('photo')
                    <p class="text-xs text-danger text-center max-w-[4rem]">{{ $message }}</p>
                @enderror

                {{-- Photo action buttons --}}
                @if($photo)
                    <div class="flex flex-col gap-1 items-center" wire:loading.remove wire:target="photo">
                        <button type="button" wire:click="savePhoto"
                                class="btn btn-primary btn-sm text-xs px-2.5">
                            Simpan Foto
                        </button>
                        <button type="button" wire:click="$set('photo', null)"
                                class="text-xs text-ink-muted hover:text-danger transition-colors">
                            Batal
                        </button>
                    </div>
                @elseif(auth()->user()->avatar)
                    <button type="button"
                            wire:click="removePhoto"
                            wire:confirm="Hapus foto profil?"
                            class="text-xs text-ink-muted hover:text-danger transition-colors">
                        Hapus foto
                    </button>
                @endif
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <div class="font-display font-bold text-ink text-lg">{{ auth()->user()->name }}</div>
                <div class="text-sm text-ink-muted mt-0.5">{{ auth()->user()->email }}</div>
                @if(auth()->user()->phone)
                    <div class="text-sm text-ink-muted mt-0.5">{{ auth()->user()->phone }}</div>
                @endif
                <div class="mt-3">
                    <span class="badge badge-success">Akun Aktif</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit form --}}
    <div class="bg-white border border-border rounded-2xl overflow-hidden">
        <div class="px-5 py-4 border-b border-border">
            <h2 class="font-display font-bold text-ink text-[0.9375rem]">Ubah Informasi</h2>
        </div>
        <div class="px-5 py-5">
            <div class="flex flex-col gap-5">

                <div>
                    <label class="block text-sm font-semibold text-ink mb-1.5">Nama Lengkap</label>
                    <input type="text" wire:model="name" class="input">
                    @error('name')
                        <p class="text-sm text-danger mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-ink mb-1.5">Alamat Email</label>
                    <input type="email" wire:model="email" class="input">
                    @error('email')
                        <p class="text-sm text-danger mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-ink mb-1.5">Nomor Telepon</label>
                    <input type="tel" wire:model="phone" class="input" placeholder="08xxxxxxxxxx">
                    @error('phone')
                        <p class="text-sm text-danger mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <button type="button"
                            wire:click="save"
                            wire:loading.attr="disabled"
                            wire:target="save"
                            class="btn btn-primary btn-sm">
                        <span wire:loading.remove wire:target="save">Simpan Perubahan</span>
                        <span wire:loading wire:target="save">Menyimpan…</span>
                    </button>

                    @if($saved)
                        <span class="flex items-center gap-1 text-sm text-success font-medium"
                              x-data x-init="setTimeout(() => $el.remove(), 3000)">
                            <x-lucide-check class="w-4 h-4" />
                            Tersimpan
                        </span>
                    @endif
                </div>

            </div>
        </div>
    </div>

    {{-- Security --}}
    <div class="bg-white border border-border rounded-2xl overflow-hidden">
        <div class="px-5 py-4 border-b border-border">
            <h2 class="font-display font-bold text-ink text-[0.9375rem]">Keamanan Akun</h2>
        </div>
        <div class="px-5 py-5 flex items-center justify-between gap-4">
            <div>
                <div class="text-sm font-medium text-ink">Password</div>
                <div class="text-xs text-ink-muted mt-0.5">Ganti password secara berkala untuk keamanan akunmu.</div>
            </div>
            <a href="{{ route('password.request') }}" class="btn btn-secondary btn-sm shrink-0">
                Ubah Password
            </a>
        </div>
    </div>

</div>
