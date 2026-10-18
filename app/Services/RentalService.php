<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Rental;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RentalService
{
    public function rent(array $data): Rental
    {
        return DB::transaction(function () use ($data) {
            $book = Book::where('book_id', $data['book_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if (! $book->isAvailable()) {
                throw ValidationException::withMessages([
                    'book_id' => 'The selected book is no longer available for rent.',
                ]);
            }

            $rental = Rental::create([
                'borrower_id' => $data['borrower_id'],
                'book_id' => $book->book_id,
                'rental_date' => $data['rental_date'],
                'return_date' => null,
                'status' => Rental::STATUS_RENTED,
            ]);

            $book->update(['status' => Book::STATUS_RENTED]);

            return $rental;
        });
    }

    public function return(Rental $rental): void
    {
        DB::transaction(function () use ($rental) {
            $lockedRental = Rental::where('rental_id', $rental->rental_id)
                ->lockForUpdate()
                ->firstOrFail();

            if (! $lockedRental->isActive()) {
                return;
            }

            $book = Book::where('book_id', $lockedRental->book_id)
                ->lockForUpdate()
                ->firstOrFail();

            $lockedRental->update([
                'status' => Rental::STATUS_RETURNED,
                'return_date' => now()->toDateString(),
            ]);

            $book->update(['status' => Book::STATUS_AVAILABLE]);
        });
    }
}
