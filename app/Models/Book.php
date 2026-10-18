<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    public const STATUS_AVAILABLE = 'Available';
    public const STATUS_RENTED = 'Rented';

    protected $primaryKey = 'book_id';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'author',
        'description',
        'cover_image',
        'published_year',
        'price',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'published_year' => 'integer',
    ];

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class, 'book_id', 'book_id');
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_AVAILABLE);
    }

    public function scopeRented(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_RENTED);
    }

    public function isAvailable(): bool
    {
        return $this->status === self::STATUS_AVAILABLE;
    }

    public function getCoverUrlAttribute(): ?string
    {
        return $this->cover_image ? asset($this->cover_image) : null;
    }
}
