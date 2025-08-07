<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'author_id',
        'published_year',
        'genre_id',
        'pages',
    ];

    public function author(): BelongsTo{
        return $this->belongsTo(Author::class);
    }

    public function genre(): BelongsTo{
        return $this->belongsTo(Genre::class);
    }
    
    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}
