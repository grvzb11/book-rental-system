<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrower;
use App\Models\Rental;

class DashboardController extends Controller
{
    public function index()
    {
        $bookCount = Book::count();
        $availableCount = Book::available()->count();
        $rentedCount = Book::rented()->count();
        $borrowerCount = Borrower::count();
        $totalRentalCount = Rental::count();
        $returnedCount = Rental::returned()->count();

        return view('dashboard', [
            'bookCount' => $bookCount,
            'availableCount' => $availableCount,
            'rentedCount' => $rentedCount,
            'borrowerCount' => $borrowerCount,
            'totalRentalCount' => $totalRentalCount,
            'returnedCount' => $returnedCount,
            'availabilityRate' => $bookCount > 0 ? (int) round(($availableCount / $bookCount) * 100) : 0,
            'todayRentalCount' => Rental::whereDate('rental_date', '=', today()->toDateString())->count(),
            'todayReturnCount' => Rental::whereDate('return_date', '=', today()->toDateString())->count(),
            'recentRentals' => Rental::with(['borrower', 'book'])
                ->orderByDesc('rental_id')
                ->take(6)
                ->get(),
            'activeRentals' => Rental::with(['borrower', 'book'])
                ->active()
                ->orderByDesc('rental_date')
                ->orderByDesc('rental_id')
                ->take(6)
                ->get(),
        ]);
    }
}
