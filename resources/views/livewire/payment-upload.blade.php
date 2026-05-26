<?php

use App\Actions\Bookings\UploadPaymentProofAction;
use App\Models\Booking;
use App\Models\Payment;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public Booking $booking;

    public ?Payment $existingPayment = null;

    public bool $showForm = false;

    // Form fields
    public $proofImage = null;

    public string $paymentMethod = '';

    public string $amount = '';

    public string $paidAt = '';

    public function mount(Booking $booking): void
    {
        $this->booking = $booking;
        $this->existingPayment = $booking->payments()->latest()->first();
        $this->amount = (string) $booking->total_price;
        $this->paidAt = now()->format('Y-m-d');
        $this->showForm = $this->existingPayment === null && $booking->status === 'pending';
    }

    public function openForm(): void
    {
        $this->showForm = true;
        $this->proofImage = null;
        $this->resetErrorBag();
    }

    public function submit(UploadPaymentProofAction $action): void
    {
        $this->validate([
            'proofImage'    => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'paymentMethod' => ['required', 'string', 'max:50'],
            'amount'        => ['required', 'integer', 'min:1'],
            'paidAt'        => ['required', 'date', 'before_or_equal:today'],
        ]);

        $this->existingPayment = $action->execute($this->booking, [
            'proof_image'    => $this->proofImage,
            'payment_method' => $this->paymentMethod,
            'amount'         => (int) $this->amount,
            'paid_at'        => $this->paidAt,
        ]);

        $this->showForm = false;
        $this->proofImage = null;

        $this->dispatch('payment-proof-uploaded');
    }
}; ?>

<div>

    {{-- Booking confirmed --}}
    @if($booking->status === 'confirmed')
        <div class="bg-success-surface border border-success/20 rounded-2xl p-5 flex gap-3">
            <x-lucide-check-circle class="w-5 h-5 text-success mt-0.5 shrink-0" />
            <div class="text-sm">
                <div class="font-semibold text-success mb-0.5">Pembayaran Terverifikasi</div>
                <div class="text-ink-muted">Booking kamu sudah dikonfirmasi. Sampai jumpa di trip!</div>
            </div>
        </div>

    {{-- Payment pending verification --}}
    @elseif(!$showForm && $existingPayment?->status === 'pending')
        <div class="bg-white border border-border rounded-2xl p-5 flex flex-col gap-4">
            <div class="flex items-center gap-2">
                <x-lucide-clock class="w-4 h-4 text-warning" />
                <h2 class="font-display font-bold text-ink text-[0.9375rem]">Menunggu Verifikasi</h2>
            </div>

            <p class="text-sm text-ink-muted">
                Bukti pembayaran kamu sudah diterima dan sedang diverifikasi oleh tim kami.
            </p>

            @if($existingPayment->proof_image)
                <div class="rounded-xl overflow-hidden border border-border">
                    <img src="{{ Storage::disk('public')->url($existingPayment->proof_image) }}"
                         alt="Bukti pembayaran"
                         class="w-full object-cover max-h-48">
                </div>
            @endif

            <div class="bg-surface-sunken rounded-lg p-3 flex flex-col gap-1.5 text-sm">
                <div class="flex justify-between">
                    <span class="text-ink-muted">Metode</span>
                    <span class="font-medium text-ink">{{ $existingPayment->payment_method }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-ink-muted">Jumlah</span>
                    <span class="font-medium text-ink">Rp {{ number_format($existingPayment->amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-ink-muted">Tanggal transfer</span>
                    <span class="font-medium text-ink">{{ $existingPayment->paid_at?->translatedFormat('d M Y') }}</span>
                </div>
            </div>

            <button type="button" wire:click="openForm" class="btn btn-ghost btn-sm w-full justify-center">
                <x-lucide-refresh-cw class="w-3.5 h-3.5" />
                Unggah Ulang
            </button>
        </div>

    {{-- Payment rejected --}}
    @elseif(!$showForm && $existingPayment?->status === 'rejected')
        <div class="bg-white border border-border rounded-2xl p-5 flex flex-col gap-4">
            <div class="flex items-center gap-2">
                <x-lucide-x-circle class="w-4 h-4 text-danger" />
                <h2 class="font-display font-bold text-ink text-[0.9375rem]">Pembayaran Ditolak</h2>
            </div>

            @if($existingPayment->notes)
                <div class="bg-danger-surface border border-danger/20 rounded-lg p-3 text-sm text-ink-secondary">
                    <span class="font-semibold text-danger block mb-0.5">Alasan:</span>
                    {{ $existingPayment->notes }}
                </div>
            @endif

            <button type="button" wire:click="openForm" class="btn btn-primary btn-md w-full justify-center">
                <x-lucide-upload class="w-4 h-4" />
                Unggah Ulang Bukti
            </button>
        </div>

    {{-- Upload form --}}
    @elseif($showForm)
        <div class="bg-white border border-border rounded-2xl p-5 flex flex-col gap-4">
            <h2 class="font-display font-bold text-ink text-[0.9375rem]">Unggah Bukti Pembayaran</h2>

            <p class="text-sm text-ink-muted">
                Transfer ke rekening berikut lalu unggah foto bukti transfer.
            </p>

            <div class="bg-surface-sunken rounded-lg p-3 text-sm flex flex-col gap-1">
                <div class="text-xs text-ink-muted">Bank BCA</div>
                <div class="font-display font-bold text-ink text-base tracking-wide">1234567890</div>
                <div class="text-xs text-ink-muted">a.n. PT TripKuy Indonesia</div>
            </div>

            {{-- Proof image upload --}}
            <div>
                <label class="block text-sm font-semibold text-ink mb-1.5">
                    Foto Bukti Transfer <span class="text-danger">*</span>
                </label>

                @if($proofImage)
                    <div class="relative mb-2 rounded-xl overflow-hidden border border-border">
                        <img src="{{ $proofImage->temporaryUrl() }}" alt="Preview" class="w-full object-cover max-h-48">
                        <button type="button"
                                wire:click="$set('proofImage', null)"
                                class="absolute top-2 right-2 btn btn-ghost btn-icon btn-sm bg-white/80 backdrop-blur-sm">
                            <x-lucide-x class="w-3.5 h-3.5" />
                        </button>
                    </div>
                @else
                    <label class="flex flex-col items-center justify-center gap-2 border-2 border-dashed border-border rounded-xl p-6 cursor-pointer hover:border-brand-400 hover:bg-brand-50 transition-colors">
                        <x-lucide-image class="w-8 h-8 text-ink-subtle" />
                        <span class="text-sm text-ink-muted text-center">
                            Klik untuk pilih foto<br>
                            <span class="text-xs">JPG, PNG, WebP · maks. 5 MB</span>
                        </span>
                        <input type="file" wire:model="proofImage" accept="image/*" class="sr-only">
                    </label>
                @endif

                <div wire:loading wire:target="proofImage" class="text-xs text-ink-muted mt-1 flex items-center gap-1">
                    <svg class="w-3 h-3 animate-spin inline" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                    </svg>
                    Mengunggah…
                </div>
                @error('proofImage')
                    <p class="text-sm text-danger mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Payment method --}}
            <div>
                <label class="block text-sm font-semibold text-ink mb-1.5">
                    Metode Pembayaran <span class="text-danger">*</span>
                </label>
                <select wire:model="paymentMethod" class="input">
                    <option value="">Pilih bank / metode</option>
                    <option value="Transfer BCA">Transfer BCA</option>
                    <option value="Transfer Mandiri">Transfer Mandiri</option>
                    <option value="Transfer BNI">Transfer BNI</option>
                    <option value="Transfer BRI">Transfer BRI</option>
                    <option value="Transfer BSI">Transfer BSI</option>
                    <option value="QRIS">QRIS</option>
                </select>
                @error('paymentMethod')
                    <p class="text-sm text-danger mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Amount --}}
            <div>
                <label class="block text-sm font-semibold text-ink mb-1.5">
                    Jumlah Transfer <span class="text-danger">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-semibold text-ink-muted">Rp</span>
                    <input type="number"
                           wire:model="amount"
                           min="1"
                           class="input pl-9">
                </div>
                @error('amount')
                    <p class="text-sm text-danger mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Paid at --}}
            <div>
                <label class="block text-sm font-semibold text-ink mb-1.5">
                    Tanggal Transfer <span class="text-danger">*</span>
                </label>
                <input type="date"
                       wire:model="paidAt"
                       max="{{ now()->format('Y-m-d') }}"
                       class="input">
                @error('paidAt')
                    <p class="text-sm text-danger mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="button"
                    wire:click="submit"
                    wire:loading.attr="disabled"
                    wire:target="submit"
                    class="btn btn-primary btn-md w-full justify-center">
                <span wire:loading.remove wire:target="submit">
                    <x-lucide-send class="w-4 h-4 inline -mt-0.5 mr-1" />
                    Kirim Bukti Pembayaran
                </span>
                <span wire:loading wire:target="submit" class="flex items-center gap-2">
                    <svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                    </svg>
                    Mengirim…
                </span>
            </button>
        </div>
    @endif

</div>
