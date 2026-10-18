<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rental extends Model
{
    public const STATUS_RENTED = 'Rented';
    public const STATUS_RETURNED = 'Returned';

    protected $primaryKey = 'rental_id';
    public $timestamps = false;

    protected $fillable = [
        'borrower_id',
        'book_id',
        'rental_date',
        'return_date',
        'status',
    ];

    protected $casts = [
        'rental_date' => 'date',
        'return_date' => 'date',
    ];

    public function borrower(): BelongsTo
    {
        return $this->belongsTo(Borrower::class, 'borrower_id', 'borrower_id');
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id', 'book_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_RENTED);
    }

    public function scopeReturned(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_RETURNED);
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_RENTED;
    }
}
