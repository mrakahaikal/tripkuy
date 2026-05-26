<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['trip_id', 'day', 'title', 'description'])]
class TripItinerary extends Model
{
    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Trip, $this> */
    public function trip(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
}
