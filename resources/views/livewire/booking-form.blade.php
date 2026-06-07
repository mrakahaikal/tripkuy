<?php

use App\Actions\Bookings\CreateBookingAction;
use App\Models\Trip;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

new class extends Component
{
    public Trip $trip;

    public $participantCount = 1;

    /** @var array<int, array<string, string>> */
    public array $participants = [];

    public string $notes = '';

    public function mount(Trip $trip): void
    {
        abort_if($trip->status !== 'published', 404);
        abort_if($trip->availableSlots() <= 0, 410);

        $this->trip = $trip;
        $this->syncParticipants();
    }

    public function increment(): void
    {
        if ($this->participantCount < $this->trip->availableSlots()) {
            $this->participantCount++;
            $this->syncParticipants();
        }
    }

    public function decrement(): void
    {
        if ($this->participantCount > 1) {
            $this->participantCount--;
            $this->syncParticipants();
        }
    }

    public function updatedParticipantCount(): void
    {
        $count = filter_var($this->participantCount, FILTER_VALIDATE_INT);
        $this->participantCount = max(1, min($count ?: 1, $this->trip->availableSlots()));
        $this->syncParticipants();
    }

    public function submit(CreateBookingAction $action)
    {
        $slots = $this->trip->availableSlots();

        $this->validate([
            'participantCount' => ['required', 'integer', 'min:1', "max:{$slots}"],
            'notes' => ['nullable', 'string', 'max:500'],
            'participants' => ['required', 'array', 'min:1'],
            'participants.*.name' => ['required', 'string', 'max:100'],
            'participants.*.id_number' => ['required', 'string', 'max:30'],
            'participants.*.date_of_birth' => ['required', 'date', 'before:today'],
            'participants.*.gender' => ['required', 'in:male,female'],
            'participants.*.phone' => ['nullable', 'string', 'max:20'],
            'participants.*.emergency_contact_name' => ['nullable', 'string', 'max:100'],
            'participants.*.emergency_contact_phone' => ['nullable', 'string', 'max:20'],
        ], [
            'participantCount.max' => 'Slot tidak mencukupi, hanya tersisa :max slot.',
            'participants.*.name.required' => 'Nama lengkap wajib diisi.',
            'participants.*.id_number.required' => 'Nomor KTP/Paspor wajib diisi.',
            'participants.*.date_of_birth.required' => 'Tanggal lahir wajib diisi.',
            'participants.*.date_of_birth.before' => 'Tanggal lahir tidak valid.',
            'participants.*.gender.required' => 'Jenis kelamin wajib dipilih.',
            'participants.*.gender.in' => 'Pilihan jenis kelamin tidak valid.',
        ], [
            'participantCount' => 'jumlah peserta',
            'notes' => 'catatan',
            'participants' => 'data peserta',
            'participants.*.name' => 'nama lengkap',
            'participants.*.id_number' => 'nomor KTP/Paspor',
            'participants.*.date_of_birth' => 'tanggal lahir',
            'participants.*.gender' => 'jenis kelamin',
            'participants.*.phone' => 'nomor telepon',
            'participants.*.emergency_contact_name' => 'nama kontak darurat',
            'participants.*.emergency_contact_phone' => 'nomor telepon kontak darurat',
        ]);

        try {
            $booking = $action->execute(auth()->user(), $this->trip, [
                'participant_count' => $this->participantCount,
                'notes' => $this->notes ?: null,
                'participants' => $this->participants,
            ]);
        } catch (ValidationException $e) {
            foreach ($e->errors() as $field => $messages) {
                $this->addError($field, $messages[0]);
            }

            return null;
        }

        $this->redirect(route('bookings.show', $booking->booking_code), navigate: true);
    }

    private function syncParticipants(): void
    {
        $blank = [
            'name' => '',
            'id_number' => '',
            'date_of_birth' => '',
            'gender' => '',
            'phone' => '',
            'emergency_contact_name' => '',
            'emergency_contact_phone' => '',
        ];

        while (count($this->participants) < $this->participantCount) {
            $this->participants[] = $blank;
        }

        $this->participants = array_values(array_slice($this->participants, 0, $this->participantCount));
    }
}; ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 py-10">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-sm text-ink-muted mb-6">
        <a href="{{ route('trips.index') }}" class="hover:text-brand-600">Trip</a>
        <x-lucide-chevron-right class="w-3.5 h-3.5" />
        <a href="{{ route('trips.show', $trip) }}" class="hover:text-brand-600">{{ $trip->title }}</a>
        <x-lucide-chevron-right class="w-3.5 h-3.5" />
        <span class="text-ink font-medium">Booking</span>
    </nav>

    <div class="flex flex-col lg:flex-row gap-6">

        {{-- ── Form ── --}}
        <div class="flex-1 min-w-0 flex flex-col gap-6">

            {{-- Jumlah peserta --}}
            <div class="bg-white border border-border rounded-2xl overflow-hidden">
                <div class="px-5 py-4 border-b border-border">
                    <h2 class="font-display font-bold text-ink text-[0.9375rem]">Jumlah Peserta</h2>
                </div>
                <div class="px-5 py-5">
                    <div class="flex items-center gap-3">
                        <button type="button"
                                wire:click="decrement"
                                @disabled($participantCount <= 1)
                                class="btn btn-ghost btn-icon btn-md disabled:opacity-40 disabled:cursor-not-allowed">
                            <x-lucide-minus class="w-4 h-4" />
                        </button>
                        <input type="number"
                               wire:model.blur="participantCount"
                               x-mask="999"
                               min="1"
                               max="{{ $trip->availableSlots() }}"
                               class="input text-center w-20">
                        <button type="button"
                                wire:click="increment"
                                @disabled($participantCount >= $trip->availableSlots())
                                class="btn btn-ghost btn-icon btn-md disabled:opacity-40 disabled:cursor-not-allowed">
                            <x-lucide-plus class="w-4 h-4" />
                        </button>
                        <span class="text-sm text-ink-muted">
                            dari <span class="font-semibold text-ink">{{ $trip->availableSlots() }}</span> slot tersedia
                        </span>
                    </div>
                    @error('participantCount')
                        <p class="text-sm text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Data peserta --}}
            @foreach($participants as $i => $participant)
                <div class="bg-white border border-border rounded-2xl overflow-hidden">
                    <div class="px-5 py-4 border-b border-border flex items-center justify-between">
                        <h2 class="font-display font-bold text-ink text-[0.9375rem]">Peserta {{ $i + 1 }}</h2>
                        @if($i === 0)
                            <span class="badge badge-brand">Pemesan</span>
                        @endif
                    </div>
                    <div class="px-5 py-5 grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-ink mb-1.5">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   wire:model="participants.{{ $i }}.name"
                                   class="input"
                                   placeholder="Sesuai KTP/Paspor">
                            @error("participants.{$i}.name")
                                <p class="text-sm text-danger mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-ink mb-1.5">
                                Nomor KTP / Paspor <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   wire:model="participants.{{ $i }}.id_number"
                                   class="input"
                                   placeholder="16 digit NIK atau nomor paspor">
                            @error("participants.{$i}.id_number")
                                <p class="text-sm text-danger mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-ink mb-1.5">
                                Tanggal Lahir <span class="text-danger">*</span>
                            </label>
                            <input type="date"
                                   wire:model="participants.{{ $i }}.date_of_birth"
                                   class="input">
                            @error("participants.{$i}.date_of_birth")
                                <p class="text-sm text-danger mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-ink mb-1.5">
                                Jenis Kelamin <span class="text-danger">*</span>
                            </label>
                            <select wire:model="participants.{{ $i }}.gender" class="input">
                                <option value="">Pilih jenis kelamin</option>
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                            @error("participants.{$i}.gender")
                                <p class="text-sm text-danger mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-ink mb-1.5">Nomor Telepon</label>
                            <input type="tel"
                                   wire:model="participants.{{ $i }}.phone"
                                   class="input"
                                   placeholder="08xxxxxxxxxx">
                            @error("participants.{$i}.phone")
                                <p class="text-sm text-danger mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-ink mb-1.5">Kontak Darurat — Nama</label>
                            <input type="text"
                                   wire:model="participants.{{ $i }}.emergency_contact_name"
                                   class="input"
                                   placeholder="Nama kerabat/keluarga">
                            @error("participants.{$i}.emergency_contact_name")
                                <p class="text-sm text-danger mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-ink mb-1.5">Kontak Darurat — Telepon</label>
                            <input type="tel"
                                   wire:model="participants.{{ $i }}.emergency_contact_phone"
                                   class="input"
                                   placeholder="08xxxxxxxxxx">
                            @error("participants.{$i}.emergency_contact_phone")
                                <p class="text-sm text-danger mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>
            @endforeach

            @error('participants')
                <p class="text-sm text-danger -mt-2">{{ $message }}</p>
            @enderror

            {{-- Catatan --}}
            <div class="bg-white border border-border rounded-2xl overflow-hidden">
                <div class="px-5 py-4 border-b border-border">
                    <h2 class="font-display font-bold text-ink text-[0.9375rem]">Catatan (opsional)</h2>
                </div>
                <div class="px-5 py-5">
                    <textarea wire:model="notes"
                              rows="3"
                              class="input resize-none"
                              placeholder="Alergi makanan, kebutuhan khusus, atau pertanyaan untuk organizer…"></textarea>
                    @error('notes')
                        <p class="text-sm text-danger mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Submit --}}
            <button type="button"
                    wire:click="submit"
                    wire:loading.attr="disabled"
                    class="btn btn-primary btn-lg w-full justify-center">
                <span wire:loading.remove wire:target="submit">
                    <x-lucide-check class="w-4 h-4 inline -mt-0.5 mr-1" />
                    Konfirmasi Booking
                </span>
                <span wire:loading wire:target="submit" class="inline-flex items-center gap-2">
                    <svg class="w-4 h-4 animate-spin inline" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                    </svg>
                    Memproses…
                </span>
            </button>

        </div>

        {{-- ── Order summary sidebar ── --}}
        <div class="w-full lg:w-72 shrink-0">
            <div class="sticky top-24 flex flex-col gap-4">

                <div class="bg-white border border-border rounded-2xl p-5 flex flex-col gap-4">

                    @if($trip->cover_image)
                        <img src="{{ $trip->cover_image_url }}"
                             alt="{{ $trip->title }}"
                             class="w-full h-32 object-cover rounded-xl">
                    @endif

                    <div>
                        <div class="text-xs text-ink-muted mb-0.5">{{ $trip->category->name }}</div>
                        <div class="font-display font-bold text-ink text-sm leading-tight">{{ $trip->title }}</div>
                        <div class="flex items-center gap-1 text-xs text-ink-muted mt-1">
                            <x-lucide-map-pin class="w-3 h-3" />
                            {{ $trip->destination }}
                        </div>
                        <div class="flex items-center gap-1 text-xs text-ink-muted mt-0.5">
                            <x-lucide-calendar class="w-3 h-3" />
                            {{ $trip->start_date->translatedFormat('d M Y') }} · {{ $trip->duration_days }} hari
                        </div>
                    </div>

                    <hr class="divider my-0">

                    <div class="flex flex-col gap-2 text-sm">
                        <div class="flex justify-between text-ink-muted">
                            <span>Harga per orang</span>
                            <span>Rp {{ number_format($trip->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-ink-muted">
                            <span>Jumlah peserta</span>
                            <span>{{ $participantCount }} orang</span>
                        </div>
                    </div>

                    <hr class="divider my-0">

                    <div class="flex justify-between items-baseline">
                        <span class="text-sm font-semibold text-ink">Total</span>
                        <span class="font-display font-extrabold text-xl text-ink">
                            Rp {{ number_format($trip->price * $participantCount, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="bg-warning-surface border border-warning/20 rounded-lg p-3 flex gap-2 text-xs text-ink-secondary">
                        <x-lucide-clock class="w-3.5 h-3.5 text-warning mt-0.5 shrink-0" />
                        <span>Selesaikan pembayaran dalam <strong>24 jam</strong> setelah booking dikonfirmasi.</span>
                    </div>

                </div>

            </div>
        </div>

    </div>

</div>
