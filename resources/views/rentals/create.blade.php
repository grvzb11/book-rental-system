@extends('layouts.app')

@section('title', 'New Rental | Book Rental System')
@section('topbar_title', 'New Rental')
@section('topbar_subtitle', 'Create a book checkout transaction')

@section('content')
<div class="page-heading"><div><div class="eyebrow">Transactions</div><h1>Rent a Book</h1><p>Select a registered borrower and an available book to create a rental.</p></div></div>

<div class="form-layout rental-form-layout">
    <section class="panel form-card">
        <form method="POST" action="{{ route('rentals.store') }}">
            @csrf
            <div class="form-section">
                <div class="form-section-heading"><div><span class="section-kicker">Rental details</span><h2>Checkout information</h2></div></div>

                @if ($borrowers->isEmpty() || $books->isEmpty())
                    <div class="inline-notice warning-notice">
                        <strong>Rental cannot be created yet.</strong>
                        <span>
                            @if ($borrowers->isEmpty()) Register at least one borrower. @endif
                            @if ($books->isEmpty()) Add or return a book so at least one title is available. @endif
                        </span>
                    </div>
                @endif

                <div class="form-grid">
                    <div class="field full">
                        <label for="borrower_id">Borrower <span>*</span></label>
                        <select class="@error('borrower_id') invalid @enderror" id="borrower_id" name="borrower_id" required>
                            <option value="">Select a borrower</option>
                            @foreach ($borrowers as $borrower)<option value="{{ $borrower->borrower_id }}" @selected(old('borrower_id') == $borrower->borrower_id)>{{ $borrower->name }} — {{ $borrower->contact_number }}</option>@endforeach
                        </select>
                        @error('borrower_id')<small class="field-error">{{ $message }}</small>@enderror
                    </div>
                    <div class="field full">
                        <label for="book_id">Available Book <span>*</span></label>
                        <select class="@error('book_id') invalid @enderror" id="book_id" name="book_id" required data-book-select>
                            <option value="">Select an available book</option>
                            @foreach ($books as $book)
                                <option value="{{ $book->book_id }}"
                                    data-title="{{ $book->title }}"
                                    data-author="{{ $book->author }}"
                                    data-year="{{ $book->published_year }}"
                                    data-price="₱{{ number_format((float) $book->price, 2) }}"
                                    data-cover="{{ $book->cover_url ?? '' }}"
                                    @selected(old('book_id', request('book_id')) == $book->book_id)>{{ $book->title }} — {{ $book->author }}</option>
                            @endforeach
                        </select>
                        <small class="field-hint">Only books currently marked Available are shown.</small>
                        @error('book_id')<small class="field-error">{{ $message }}</small>@enderror
                    </div>

                    <div class="selected-book-preview" data-selected-book-preview hidden>
                        <div class="selected-book-cover" data-selected-book-cover><span>BOOK</span></div>
                        <div><span class="section-kicker">Selected book</span><strong data-selected-book-title>—</strong><small data-selected-book-meta>—</small><b data-selected-book-price>—</b></div>
                    </div>

                    <div class="field full">
                        <label for="rental_date">Rental Date <span>*</span></label>
                        <input class="@error('rental_date') invalid @enderror" id="rental_date" name="rental_date" type="date" max="{{ now()->toDateString() }}" value="{{ old('rental_date', now()->toDateString()) }}" required>
                        @error('rental_date')<small class="field-error">{{ $message }}</small>@enderror
                    </div>
                </div>
            </div>
            <div class="form-actions"><a class="btn ghost" href="{{ route('rentals.index') }}">Cancel</a><button class="btn primary" type="submit" @disabled($borrowers->isEmpty() || $books->isEmpty())>Confirm Rental</button></div>
        </form>
    </section>

    <aside class="form-aside process-aside">
        <span class="section-kicker">What happens next</span>
        <h2>Rental workflow</h2>
        <ol class="process-list">
            <li><span>1</span><div><strong>Validate selection</strong><p>The system confirms that the borrower exists and the book is still available.</p></div></li>
            <li><span>2</span><div><strong>Create rental</strong><p>A new rental record is saved with the status <b>Rented</b>.</p></div></li>
            <li><span>3</span><div><strong>Update book</strong><p>The selected book automatically changes from <b>Available</b> to <b>Rented</b>.</p></div></li>
        </ol>
    </aside>
</div>
@endsection
