<?php

namespace App\Http\Controllers;

use App\Http\Requests\RentalRequest;
use App\Models\Book;
use App\Models\Borrower;
use App\Models\Rental;
use App\Services\RentalService;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function __construct(private readonly RentalService $rentalService)
    {
    }

    public function index(Request $request)
    {
        $query = Rental::query()->with(['borrower', 'book']);

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($builder) use ($search) {
                $builder->whereHas('borrower', fn ($q) => $q->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('book', function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%")
                            ->orWhere('author', 'like', "%{$search}%");
                    });
            });
        }

        if (in_array($request->input('status'), [Rental::STATUS_RENTED, Rental::STATUS_RETURNED], true)) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('from')) {
            $query->whereDate('rental_date', '>=', $request->input('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('rental_date', '<=', $request->input('to'));
        }

        return view('rentals.index', [
            'rentals' => $query->orderByDesc('rental_date')->orderByDesc('rental_id')
                ->paginate(12)->withQueryString(),
            'totalRentalCount' => Rental::count(),
            'activeRentalCount' => Rental::active()->count(),
            'returnedCount' => Rental::returned()->count(),
        ]);
    }

    public function create()
    {
        return view('rentals.create', [
            'borrowers' => Borrower::orderBy('name')->get(),
            'books' => Book::available()->orderBy('title')->get(),
        ]);
    }

    public function store(RentalRequest $request)
    {
        $this->rentalService->rent($request->validated());

        return redirect()->route('rentals.index')
            ->with('success', 'Rental created successfully. The book is now marked as Rented.');
    }

    public function returnBook(Rental $rental)
    {
        if (! $rental->isActive()) {
            return back()->with('error', 'This rental has already been completed.');
        }

        $this->rentalService->return($rental);

        return redirect()->route('rentals.index')
            ->with('success', 'Book returned successfully and is available again.');
    }
}
