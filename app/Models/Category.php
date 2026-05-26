<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'slug', 'icon', 'image'])]
class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    /** @return \Illuminate\Database\Eloquent\Relations\HasMany<Trip, $this> */
    public function trips(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Trip::class);
    }
}
