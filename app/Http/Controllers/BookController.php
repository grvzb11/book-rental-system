<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Services\BookCoverService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct(private readonly BookCoverService $bookCoverService)
    {
    }

    public function index(Request $request)
    {
        $query = Book::query()->withCount('rentals');

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (in_array($request->input('status'), [Book::STATUS_AVAILABLE, Book::STATUS_RENTED], true)) {
            $query->where('status', $request->input('status'));
        }

        $sort = (string) $request->input('sort', 'title');
        match ($sort) {
            'author' => $query->orderBy('author')->orderBy('title'),
            'year_desc' => $query->orderByDesc('published_year')->orderBy('title'),
            'year_asc' => $query->orderBy('published_year')->orderBy('title'),
            'price_desc' => $query->orderByDesc('price')->orderBy('title'),
            'price_asc' => $query->orderBy('price')->orderBy('title'),
            default => $query->orderBy('title'),
        };

        return view('books.index', [
            'books' => $query->paginate(12)->withQueryString(),
            'bookCount' => Book::count(),
            'availableCount' => Book::available()->count(),
            'rentedCount' => Book::rented()->count(),
        ]);
    }

    public function show(Book $book)
    {
        return view('books.show', [
            'book' => $book,
            'rentals' => $book->rentals()
                ->with('borrower')
                ->orderByDesc('rental_date')
                ->orderByDesc('rental_id')
                ->paginate(8),
        ]);
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(BookRequest $request)
    {
        $data = $request->safe()->except(['cover_image', 'remove_cover']);
        $data['cover_image'] = $this->bookCoverService->replace($request->file('cover_image'));
        $data['status'] = Book::STATUS_AVAILABLE;

        $book = Book::create($data);

        return redirect()->route('books.show', $book)
            ->with('success', 'Book added to the catalog successfully.');
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(BookRequest $request, Book $book)
    {
        $data = $request->safe()->except(['cover_image', 'remove_cover']);
        $data['cover_image'] = $this->bookCoverService->replace(
            $request->file('cover_image'),
            $book->cover_image,
            $request->boolean('remove_cover')
        );

        $book->update($data);

        return redirect()->route('books.show', $book)
            ->with('success', 'Book information updated successfully.');
    }

    public function destroy(Book $book)
    {
        if ($book->rentals()->exists()) {
            return back()->with('error', 'This book has rental history and cannot be deleted.');
        }

        $coverImage = $book->cover_image;
        $book->delete();
        $this->bookCoverService->delete($coverImage);

        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully.');
    }
}
