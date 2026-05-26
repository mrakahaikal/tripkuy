<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'slug', 'description'])]
class PostCategory extends Model
{
    /** @use HasFactory<\Database\Factories\PostCategoryFactory> */
    use HasFactory;

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<Post, $this> */
    public function posts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Post::class);
    }
}
