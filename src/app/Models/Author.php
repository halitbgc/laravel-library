<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    /** @use HasFactory<\Database\Factories\AuthorFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'biography',
        'birth_date',
        'death_date',
    ];

    public function books():HasMany
    {
        return $this->hasMany(Book::class);
    }
}
