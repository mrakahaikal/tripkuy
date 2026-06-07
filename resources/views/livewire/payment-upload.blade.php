<?php

use App\Actions\Bookings\UploadPaymentProofAction;
use App\Models\Booking;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public Booking $booking;

    public bool $showForm = false;

    public $proofImage = null;

    public string $paymentMethod = '';

    public string $amount = '';

    public string $paidAt = '';

    public function mount(): void
    {
        $this->paidAt = now()->format('Y-m-d');
        $this->recalculateAmount();

        $hasPendingPayment = $this->booking->payments()->where('status', 'pending')->exists();
        $this->showForm = $this->booking->status === 'pending' && ! $hasPendingPayment;
    }

    public function openForm(): void
    {
        $this->recalculateAmount();
        $this->paidAt = now()->format('Y-m-d');
        $this->proofImage = null;
        $this->resetErrorBag();
        $this->showForm = true;
    }

    public function closeForm(): void
    {
        $this->showForm = false;
        $this->proofImage = null;
        $this->resetErrorBag();
    }

    public function submit(UploadPaymentProofAction $action): void
    {
        $verified = $this->booking->payments()->where('status', 'verified')->sum('amount');
        $remaining = max(0, $this->booking->total_price - $verified);

        $this->validate([
            'proofImage'    => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'paymentMethod' => ['required', 'string', 'max:50'],
            'amount'        => ['required', 'integer', 'min:1', "max:{$remaining}"],
            'paidAt'        => ['required', 'date', 'before_or_equal:today'],
        ], [
            'amount.max' => 'Jumlah melebihi sisa tagihan (Rp ' . number_format($remaining, 0, ',', '.') . ').',
        ]);

        $action->execute($this->booking, [
            'proof_image'    => $this->proofImage,
            'payment_method' => $this->paymentMethod,
            'amount'         => (int) $this->amount,
            'paid_at'        => $this->paidAt,
        ]);

        $this->showForm = false;
        $this->proofImage = null;

        $this->dispatch('payment-proof-uploaded');
    }

    private function recalculateAmount(): void
    {
        $verified = $this->booking->payments()->where('status', 'verified')->sum('amount');
        $remaining = max(0, $this->booking->total_price - $verified);
        $this->amount = (string) ($remaining ?: $this->booking->total_price);
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        $payments = $this->booking->payments()->latest()->get();
        $verifiedTotal = $payments->where('status', 'verified')->sum('amount');
        $remaining = max(0, $this->booking->total_price - $verifiedTotal);

        return view('livewire.payment-upload', compact('payments', 'verifiedTotal', 'remaining'));
    }
}; ?>

<div class="flex flex-col gap-4">

    {{-- Confirmed banner --}}
    @if($booking->status === 'confirmed')
        <div class="bg-success-surface border border-success/20 rounded-2xl p-5 flex gap-3">
            <x-lucide-check-circle class="w-5 h-5 text-success mt-0.5 shrink-0" />
            <div class="text-sm">
                <div class="font-semibold text-success mb-0.5">Pembayaran Terverifikasi</div>
                <div class="text-ink-muted">Booking kamu sudah dikonfirmasi. Sampai jumpa di trip!</div>
            </div>
        </div>
    @endif

    {{-- Payment history --}}
    @if($payments->isNotEmpty())
        <div class="bg-white border border-border rounded-2xl p-5 flex flex-col gap-3">
            <h2 class="font-display font-bold text-ink text-[0.9375rem]">Riwayat Pembayaran</h2>

            {{-- Summary bar (pending booking with partial verified payments) --}}
            @if($booking->status === 'pending' && $verifiedTotal > 0)
                <div class="bg-surface-sunken rounded-lg p-3 text-sm flex flex-col gap-1">
                    <div class="flex justify-between">
                        <span class="text-ink-muted">Total tagihan</span>
                        <span class="font-medium text-ink">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-ink-muted">Sudah terbayar</span>
                        <span class="font-semibold text-success">Rp {{ number_format($verifiedTotal, 0, ',', '.') }}</span>
                    </div>
                    @if($remaining > 0)
                        <div class="flex justify-between border-t border-border pt-1.5 mt-0.5">
                            <span class="font-semibold text-ink">Sisa tagihan</span>
                            <span class="font-bold text-coral-600">Rp {{ number_format($remaining, 0, ',', '.') }}</span>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Payment list --}}
            <div class="flex flex-col gap-2">
                @foreach($payments as $payment)
                    <div class="border border-border rounded-xl p-3 flex flex-col gap-2">
                        <div class="flex items-center justify-between">
                            @if($payment->status === 'verified')
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-success">
                                    <x-lucide-check-circle class="w-3.5 h-3.5" /> Terverifikasi
                                </span>
                            @elseif($payment->status === 'pending')
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-warning">
                                    <x-lucide-clock class="w-3.5 h-3.5" /> Menunggu verifikasi
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-danger">
                                    <x-lucide-x-circle class="w-3.5 h-3.5" /> Ditolak
                                </span>
                            @endif
                            <span class="text-xs text-ink-muted">{{ $payment->paid_at?->translatedFormat('d M Y') }}</span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-ink-muted">{{ $payment->payment_method }}</span>
                            <span class="font-semibold text-ink">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                        </div>

                        @if($payment->status === 'rejected' && $payment->notes)
                            <div class="bg-danger-surface rounded-md px-2.5 py-1.5 text-xs text-danger">
                                {{ $payment->notes }}
                            </div>
                        @endif

                        @if($payment->proof_image)
                            <a href="{{ Storage::disk('public')->url($payment->proof_image) }}" target="_blank" rel="noopener">
                                <img src="{{ Storage::disk('public')->url($payment->proof_image) }}"
                                     alt="Bukti pembayaran"
                                     class="w-full rounded-lg object-cover max-h-28 border border-border hover:opacity-90 transition-opacity">
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Upload section — only for pending booking --}}
    @if($booking->status === 'pending')
        @if($showForm)
            <div class="bg-white border border-border rounded-2xl p-5 flex flex-col gap-4"
                 x-data="{
                     selected: @js($paymentMethod),
                     banks: {
                         'Transfer BCA':     { label: 'Bank BCA',     number: '1234 5678 9012', name: 'PT TripKuy Indonesia' },
                         'Transfer Mandiri': { label: 'Bank Mandiri', number: '1234 5678 9012', name: 'PT TripKuy Indonesia' },
                         'Transfer BNI':     { label: 'Bank BNI',     number: '1234 5678 9012', name: 'PT TripKuy Indonesia' },
                         'Transfer BRI':     { label: 'Bank BRI',     number: '1234 5678 9012', name: 'PT TripKuy Indonesia' },
                         'Transfer BSI':     { label: 'Bank BSI',     number: '1234 5678 9012', name: 'PT TripKuy Indonesia' },
                     }
                 }">
                <div class="flex items-center justify-between">
                    <h2 class="font-display font-bold text-ink text-[0.9375rem]">Unggah Bukti Pembayaran</h2>
                    @if($payments->isNotEmpty())
                        <button type="button" wire:click="closeForm" class="btn btn-ghost btn-icon btn-sm">
                            <x-lucide-x class="w-4 h-4" />
                        </button>
                    @endif
                </div>

                <p class="text-sm text-ink-muted">
                    Transfer ke rekening berikut lalu unggah foto bukti transfer.
                </p>

                <div class="bg-surface-sunken rounded-lg p-3 text-sm flex flex-col gap-1"
                     x-show="banks[selected]"
                     x-cloak>
                    <div class="text-xs text-ink-muted" x-text="banks[selected]?.label"></div>
                    <div class="font-display font-bold text-ink text-base tracking-wide"
                         x-show="banks[selected]?.number"
                         x-text="banks[selected]?.number"></div>
                    <div class="text-xs text-ink-muted" x-text="banks[selected]?.name"></div>
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
                        <svg class="w-3 h-3 animate-spin" viewBox="0 0 24 24" fill="none">
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
                    <select wire:model="paymentMethod"
                            x-on:change="selected = $event.target.value"
                            class="input">
                        <option value="">Pilih bank / metode</option>
                        <option value="Transfer BCA">Transfer BCA</option>
                        <option value="Transfer Mandiri">Transfer Mandiri</option>
                        <option value="Transfer BNI">Transfer BNI</option>
                        <option value="Transfer BRI">Transfer BRI</option>
                        <option value="Transfer BSI">Transfer BSI</option>
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
                        <input type="number" wire:model="amount" min="1" max="{{ $remaining }}" class="input pl-9">
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
                    <input type="date" wire:model="paidAt" max="{{ now()->format('Y-m-d') }}" class="input">
                    @error('paidAt')
                        <p class="text-sm text-danger mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="button"
                        wire:click="submit"
                        wire:loading.attr="disabled"
                        wire:target="submit"
                        class="btn btn-primary btn-md w-full justify-center">
                    <span wire:loading.remove wire:target="submit" class="flex items-center gap-1.5">
                        <x-lucide-send class="w-4 h-4" />
                        Kirim Bukti Pembayaran
                    </span>
                    <span wire:loading wire:target="submit" class="flex items-center gap-2">
                        <svg class="w-4 h-4 animate-spin inline" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                        </svg>
                        Mengirim…
                    </span>
                </button>
            </div>
        @else
            <button type="button" wire:click="openForm" class="btn btn-primary btn-md w-full justify-center">
                <x-lucide-upload class="w-4 h-4" />
                Tambah Bukti Pembayaran
            </button>
        @endif
    @endif

</div>
