<?php

namespace App\Models;

use Database\Factories\TripFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'category_id', 'title', 'slug', 'description', 'highlight', 'destination', 'departure_city',
    'start_date', 'end_date', 'duration_days', 'price', 'quota', 'min_participants',
    'cover_image', 'status', 'difficulty_level', 'meeting_point', 'includes', 'excludes',
    'cancelled_at',
])]
class Trip extends Model
{
    /** @use HasFactory<TripFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'includes' => 'array',
            'excludes' => 'array',
        ];
    }

    /** @return BelongsTo<Category, $this> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /** @return HasMany<TripItinerary, $this> */
    public function itineraries(): HasMany
    {
        return $this->hasMany(TripItinerary::class)->orderBy('day');
    }

    /** @return HasMany<TripImage, $this> */
    public function images(): HasMany
    {
        return $this->hasMany(TripImage::class)->orderBy('order');
    }

    /** @return HasMany<Booking, $this> */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /** @return HasMany<Review, $this> */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /** @return HasMany<TripFaq, $this> */
    public function faqs(): HasMany
    {
        return $this->hasMany(TripFaq::class)->orderBy('order');
    }

    /** @return BelongsToMany<User, $this> */
    public function wishlistedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'trip_wishlists')->withTimestamps();
    }

    protected function coverImageUrl(): Attribute
    {
        return Attribute::make(
            get: function (): ?string {
                if (! $this->cover_image) {
                    return null;
                }

                return str_starts_with($this->cover_image, 'http')
                    ? $this->cover_image
                    : Storage::url($this->cover_image);
            }
        );
    }

    public function availableSlots(): int
    {
        $confirmed = $this->bookings()->where('status', 'confirmed')->sum('participant_count');

        return max(0, $this->quota - $confirmed);
    }

    public function isAvailable(): bool
    {
        return $this->status === 'published' && $this->availableSlots() > 0;
    }
}
