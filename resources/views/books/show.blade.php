@extends('layouts.app')

@section('title', $book->title . ' | Book Rental System')
@section('topbar_title', 'Book Details')
@section('topbar_subtitle', 'Catalog profile and rental history')

@section('content')
<div class="page-heading split detail-heading">
    <div><div class="eyebrow">Catalog record</div><h1>{{ $book->title }}</h1><p>Review the book profile, availability, and transaction history.</p></div>
    <div class="heading-actions"><a class="btn ghost" href="{{ route('books.index') }}">Back to Books</a><a class="btn primary" href="{{ route('books.edit', $book) }}">Edit Book</a></div>
</div>

<div class="detail-grid">
    <section class="panel book-profile-card">
        <div class="book-profile-cover">
            @if ($book->cover_url)
                <img src="{{ $book->cover_url }}" alt="Cover of {{ $book->title }}">
            @else
                <div class="book-cover-placeholder"><span>{{ strtoupper(substr($book->title, 0, 1)) }}</span><small>No cover image</small></div>
            @endif
        </div>
        <div class="book-profile-main">
            <div class="detail-title-row"><div><span class="section-kicker">Book #{{ $book->book_id }}</span><h2>{{ $book->title }}</h2><p>by {{ $book->author }}</p></div><span class="badge {{ $book->status === 'Available' ? 'success' : 'warning' }}">{{ $book->status }}</span></div>
            <div class="detail-facts">
                <div><span>Published</span><strong>{{ $book->published_year }}</strong></div>
                <div><span>Price</span><strong>₱{{ number_format((float) $book->price, 2) }}</strong></div>
                <div><span>Rental records</span><strong>{{ $rentals->total() }}</strong></div>
            </div>
            <div class="description-block"><span>Description</span><p>{{ $book->description ?: 'No description has been provided for this book.' }}</p></div>
            <div class="detail-actions">
                @if ($book->isAvailable())
                    <a class="btn primary" href="{{ route('rentals.create', ['book_id' => $book->book_id]) }}">Rent This Book</a>
                @else
                    <span class="inline-status-note">This copy is currently rented and will become available after return.</span>
                @endif
            </div>
        </div>
    </section>

    <aside class="panel detail-side-card">
        <div class="panel-header"><div><span class="section-kicker">Record summary</span><h2>Catalog status</h2></div></div>
        <div class="detail-summary-list">
            <div><span>Book ID</span><strong>#{{ $book->book_id }}</strong></div>
            <div><span>Availability</span><strong>{{ $book->status }}</strong></div>
            <div><span>Rental history</span><strong>{{ $rentals->total() }} records</strong></div>
            <div><span>Cover image</span><strong>{{ $book->cover_image ? 'Uploaded' : 'Not added' }}</strong></div>
        </div>
    </aside>
</div>

<section class="panel table-panel detail-history-panel">
    <div class="panel-header table-panel-head"><div><span class="section-kicker">History</span><h2>Rental history</h2></div><span class="result-count">{{ $rentals->total() }} {{ $rentals->total() === 1 ? 'transaction' : 'transactions' }}</span></div>
    @if ($rentals->isEmpty())
        <div class="empty-state compact-empty"><div class="empty-icon">↔</div><strong>No rental history</strong><span>This book has not been rented yet.</span></div>
    @else
        <div class="table-wrap"><table class="data-table"><thead><tr><th>Rental ID</th><th>Borrower</th><th>Rental Date</th><th>Return Date</th><th>Status</th></tr></thead><tbody>
        @foreach ($rentals as $rental)
            <tr><td><span class="table-id">#{{ $rental->rental_id }}</span></td><td><a class="table-link" href="{{ route('borrowers.show', $rental->borrower) }}">{{ $rental->borrower->name }}</a></td><td>{{ $rental->rental_date->format('M d, Y') }}</td><td>{{ $rental->return_date?->format('M d, Y') ?? '—' }}</td><td><span class="badge {{ $rental->status === 'Returned' ? 'success' : 'warning' }}">{{ $rental->status }}</span></td></tr>
        @endforeach
        </tbody></table></div>
        {{ $rentals->links('partials.pagination') }}
    @endif
</section>
@endsection
