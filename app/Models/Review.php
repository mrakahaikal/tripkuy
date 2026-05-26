<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['trip_id', 'user_id', 'booking_id', 'rating', 'comment'])]
class Review extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewFactory> */
    use HasFactory;

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Trip, $this> */
    public function trip(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, $this> */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Booking, $this> */
    public function booking(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
