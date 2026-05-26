<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'booking_id', 'amount', 'payment_method', 'proof_image',
    'status', 'notes', 'paid_at', 'verified_at', 'verified_by',
])]
class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
            'verified_at' => 'datetime',
        ];
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Booking, $this> */
    public function booking(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, $this> */
    public function verifier(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
