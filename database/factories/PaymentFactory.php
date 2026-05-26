<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    public function definition(): array
    {
        $methods = ['Transfer BCA', 'Transfer Mandiri', 'Transfer BRI', 'Transfer BNI', 'Transfer CIMB'];

        return [
            'booking_id' => Booking::factory(),
            'amount' => fake()->randomElement([500_000, 750_000, 1_000_000, 1_500_000, 2_000_000]),
            'payment_method' => fake()->randomElement($methods),
            'proof_image' => 'payments/proof-placeholder.jpg',
            'status' => 'pending',
            'notes' => null,
            'paid_at' => now(),
            'verified_at' => null,
            'verified_by' => null,
        ];
    }

    public function verified(): static
    {
        return $this->state([
            'status' => 'verified',
            'verified_at' => now(),
        ]);
    }

    public function rejected(): static
    {
        return $this->state([
            'status' => 'rejected',
            'notes' => 'Bukti pembayaran tidak valid.',
        ]);
    }
}
