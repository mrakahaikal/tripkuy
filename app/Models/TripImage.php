<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['trip_id', 'image_path', 'order'])]
class TripImage extends Model
{
    /** @return BelongsTo<Trip, $this> */
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
}
