@extends('layouts.app')

@section('title', 'Books | Book Rental System')
@section('topbar_title', 'Books')
@section('topbar_subtitle', 'Catalog records and availability')

@section('content')
<div class="page-heading split">
    <div>
        <div class="eyebrow">Catalog</div>
        <h1>Books</h1>
        <p>Browse the collection visually, manage cover images, and keep track of availability and rental history.</p>
    </div>
    <a class="btn primary" href="{{ route('books.create') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
        Add Book
    </a>
</div>

<div class="page-metrics">
    <div><span>Total Books</span><strong>{{ $bookCount }}</strong></div>
    <div><span>Available</span><strong class="text-success">{{ $availableCount }}</strong></div>
    <div><span>Rented</span><strong class="text-warning">{{ $rentedCount }}</strong></div>
</div>

<form method="GET" class="filter-bar book-filters">
    <div class="search-field">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
        <input type="search" name="search" value="{{ request('search') }}" placeholder="Search title, author or description" aria-label="Search books">
    </div>
    <select name="status" aria-label="Filter books by status">
        <option value="">All statuses</option>
        <option value="Available" @selected(request('status') === 'Available')>Available</option>
        <option value="Rented" @selected(request('status') === 'Rented')>Rented</option>
    </select>
    <select name="sort" aria-label="Sort books">
        <option value="title" @selected(request('sort', 'title') === 'title')>Title A–Z</option>
        <option value="author" @selected(request('sort') === 'author')>Author A–Z</option>
        <option value="year_desc" @selected(request('sort') === 'year_desc')>Newest year</option>
        <option value="year_asc" @selected(request('sort') === 'year_asc')>Oldest year</option>
        <option value="price_asc" @selected(request('sort') === 'price_asc')>Price low–high</option>
        <option value="price_desc" @selected(request('sort') === 'price_desc')>Price high–low</option>
    </select>
    <button class="btn secondary" type="submit">Apply</button>
    @if (request()->hasAny(['search', 'status', 'sort']))
        <a class="btn ghost" href="{{ route('books.index') }}">Clear</a>
    @endif
</form>

<section class="panel media-catalog-panel">
    @if ($books->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">⌕</div>
            <strong>No books found</strong>
            <span>Try changing your filters or add a new book.</span>
        </div>
    @else
        <div class="book-media-grid">
            @foreach ($books as $book)
                <article class="book-media-card">
                    <div class="book-media-visual">
                        <a class="book-media-cover" href="{{ route('books.show', $book) }}" aria-label="View {{ $book->title }}">
                            @if ($book->cover_url)
                                <img src="{{ $book->cover_url }}" alt="Cover of {{ $book->title }}">
                            @else
                                <span class="book-media-placeholder">
                                    <b>{{ strtoupper(substr($book->title, 0, 1)) }}</b>
                                    <small>No cover</small>
                                </span>
                            @endif
                        </a>

                        <span class="book-media-id">#{{ $book->book_id }}</span>
                        <span class="badge book-media-status {{ $book->status === 'Available' ? 'success' : 'warning' }}">{{ $book->status }}</span>

                        <div class="book-media-quick-actions" aria-label="Actions for {{ $book->title }}">
                            <a class="media-action" href="{{ route('books.show', $book) }}" title="View details" aria-label="View {{ $book->title }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12z"/><circle cx="12" cy="12" r="2.5"/></svg>
                            </a>
                            <a class="media-action" href="{{ route('books.edit', $book) }}" title="Edit book" aria-label="Edit {{ $book->title }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4z"/></svg>
                            </a>
                            @if ($book->rentals_count === 0)
                                <form action="{{ route('books.destroy', $book) }}" method="POST" data-confirm="Delete “{{ $book->title }}”? This cannot be undone." data-confirm-title="Delete book">
                                    @csrf
                                    @method('DELETE')
                                    <button class="media-action danger" type="submit" title="Delete book" aria-label="Delete {{ $book->title }}">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="m19 6-1 14H6L5 6"/><path d="M10 11v5M14 11v5"/></svg>
                                    </button>
                                </form>
                            @else
                                <button class="media-action disabled" type="button" disabled title="Cannot delete a book with rental history" aria-label="Delete unavailable because rental history exists">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="m19 6-1 14H6L5 6"/></svg>
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="book-media-content">
                        <a class="book-media-title" href="{{ route('books.show', $book) }}" title="{{ $book->title }}">{{ $book->title }}</a>
                        <p class="book-media-author">{{ $book->author }}</p>

                        <div class="book-media-facts">
                            <span>{{ $book->published_year }}</span>
                            <strong>₱{{ number_format((float) $book->price, 2) }}</strong>
                        </div>

                        <p class="book-media-description">{{ $book->description ? \Illuminate\Support\Str::limit($book->description, 92) : 'No description provided.' }}</p>

                        <div class="book-media-history">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 12a9 9 0 1 0 3-6.7L3 8"/><path d="M3 3v5h5"/><path d="M12 7v5l3 2"/></svg>
                            <span>
                                @if ($book->rentals_count > 0)
                                    {{ $book->rentals_count }} historical {{ $book->rentals_count === 1 ? 'rental' : 'rentals' }}
                                @else
                                    No rental history
                                @endif
                            </span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        {{ $books->links('partials.pagination') }}
    @endif
</section>
@endsection
