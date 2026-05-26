<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'post_category_id', 'user_id', 'title', 'slug', 'excerpt',
    'content', 'cover_image', 'status', 'published_at',
])]
class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<PostCategory, $this> */
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }

    /** @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, $this> */
    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isPublished(): bool
    {
        return $this->status === 'published' && $this->published_at?->isPast();
    }
}
