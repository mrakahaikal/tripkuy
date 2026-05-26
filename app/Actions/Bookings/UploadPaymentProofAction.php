<?php

namespace App\Actions\Bookings;

use App\Mail\PaymentProofSubmittedEmail;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UploadPaymentProofAction
{
    /**
     * @param  array{
     *     proof_image: UploadedFile,
     *     payment_method: string,
     *     amount: int,
     *     paid_at: string,
     * } $data
     */
    public function execute(Booking $booking, array $data): Payment
    {
        abort_if($booking->status !== 'pending', 422, 'Booking tidak dalam status pending.');

        $existing = $booking->payments()->whereIn('status', ['pending', 'rejected'])->first();

        if ($existing) {
            Storage::disk('public')->delete($existing->proof_image);
            $existing->delete();
        }

        $path = $data['proof_image']->store('payments/proofs', 'public');

        $payment = $booking->payments()->create([
            'amount'         => $data['amount'],
            'payment_method' => $data['payment_method'],
            'proof_image'    => $path,
            'status'         => 'pending',
            'paid_at'        => $data['paid_at'],
        ]);

        Mail::to($booking->user)->send(new PaymentProofSubmittedEmail($booking));

        return $payment;
    }
}
