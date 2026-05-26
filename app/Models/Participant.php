<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'booking_id', 'name', 'id_number', 'date_of_birth', 'gender',
    'phone', 'emergency_contact_name', 'emergency_contact_phone',
])]
class Participant extends Model
{
    /** @use HasFactory<\Database\Factories\ParticipantFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Booking, $this> */
    public function booking(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
