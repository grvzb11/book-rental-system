<?php

namespace App\Http\Controllers;

use App\Http\Requests\BorrowerRequest;
use App\Models\Borrower;
use App\Models\Rental;
use Illuminate\Http\Request;

class BorrowerController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrower::query()->withCount([
            'rentals',
            'rentals as active_rentals_count' => fn ($builder) => $builder->where('status', Rental::STATUS_RENTED),
        ]);

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('contact_number', 'like', "%{$search}%");
            });
        }

        return view('borrowers.index', [
            'borrowers' => $query->orderBy('name')->paginate(10)->withQueryString(),
            'borrowerCount' => Borrower::count(),
            'activeBorrowerCount' => Borrower::whereHas('rentals', fn ($builder) => $builder->where('status', Rental::STATUS_RENTED))->count(),
            'totalRentalCount' => Rental::count(),
        ]);
    }

    public function show(Borrower $borrower)
    {
        return view('borrowers.show', [
            'borrower' => $borrower,
            'rentals' => $borrower->rentals()
                ->with('book')
                ->orderByDesc('rental_date')
                ->orderByDesc('rental_id')
                ->paginate(8),
            'activeRentalCount' => $borrower->rentals()->where('status', Rental::STATUS_RENTED)->count(),
        ]);
    }

    public function create()
    {
        return view('borrowers.create');
    }

    public function store(BorrowerRequest $request)
    {
        Borrower::create($request->validated());

        return redirect()->route('borrowers.index')
            ->with('success', 'Borrower registered successfully.');
    }

    public function edit(Borrower $borrower)
    {
        return view('borrowers.edit', compact('borrower'));
    }

    public function update(BorrowerRequest $request, Borrower $borrower)
    {
        $borrower->update($request->validated());

        return redirect()->route('borrowers.index')
            ->with('success', 'Borrower information updated successfully.');
    }

    public function destroy(Borrower $borrower)
    {
        if ($borrower->rentals()->exists()) {
            return back()->with('error', 'This borrower has rental history and cannot be deleted.');
        }

        $borrower->delete();

        return redirect()->route('borrowers.index')
            ->with('success', 'Borrower deleted successfully.');
    }
}
