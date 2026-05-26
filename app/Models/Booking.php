<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'booking_code', 'user_id', 'trip_id', 'participant_count', 'total_price',
    'status', 'notes', 'payment_deadline', 'confirmed_at', 'cancelled_at',
])]
class Booking extends Model
{
    /** @use HasFactory<\Database\Factories\BookingFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'payment_deadline' => 'datetime',
            'confirmed_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, $this> */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Trip, $this> */
    public function trip(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<Participant, $this> */
    public function participants(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Participant::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<Payment, $this> */
    public function payments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function isPaid(): bool
    {
        return $this->payments()->where('status', 'verified')->exists();
    }

    public function isPaymentOverdue(): bool
    {
        return $this->payment_deadline !== null
            && $this->payment_deadline->isPast()
            && ! $this->isPaid();
    }

    /** @return \Illuminate\Database\Eloquent\Relations\HasOne<Review, $this> */
    public function review(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Review::class);
    }
}
