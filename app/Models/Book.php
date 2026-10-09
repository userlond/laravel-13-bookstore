<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable('name', 'price', 'image', 'is_published')]
class Book extends Model
{
    use HasFactory;

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }
}
