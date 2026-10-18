@extends('layouts.app')

@section('title', $borrower->name . ' | Book Rental System')
@section('topbar_title', 'Borrower Details')
@section('topbar_subtitle', 'Borrower profile and rental history')

@section('content')
<div class="page-heading split detail-heading">
    <div><div class="eyebrow">Borrower record</div><h1>{{ $borrower->name }}</h1><p>Review contact information and the complete borrowing history.</p></div>
    <div class="heading-actions"><a class="btn ghost" href="{{ route('borrowers.index') }}">Back to Borrowers</a><a class="btn primary" href="{{ route('borrowers.edit', $borrower) }}">Edit Borrower</a></div>
</div>

<div class="borrower-profile-grid">
    <section class="panel borrower-profile-card">
        <div class="profile-avatar-large">{{ strtoupper(substr($borrower->name, 0, 1)) }}</div>
        <div><span class="section-kicker">Borrower #{{ $borrower->borrower_id }}</span><h2>{{ $borrower->name }}</h2><p>{{ $borrower->contact_number }}</p></div>
    </section>
    <div class="page-metrics profile-metrics">
        <div><span>Total Rentals</span><strong>{{ $rentals->total() }}</strong></div>
        <div><span>Active Rentals</span><strong class="text-warning">{{ $activeRentalCount }}</strong></div>
        <div><span>Completed</span><strong class="text-success">{{ max(0, $rentals->total() - $activeRentalCount) }}</strong></div>
    </div>
</div>

<section class="panel table-panel detail-history-panel">
    <div class="panel-header table-panel-head"><div><span class="section-kicker">History</span><h2>Rental activity</h2></div><span class="result-count">{{ $rentals->total() }} {{ $rentals->total() === 1 ? 'transaction' : 'transactions' }}</span></div>
    @if ($rentals->isEmpty())
        <div class="empty-state compact-empty"><div class="empty-icon">↔</div><strong>No rental history</strong><span>This borrower has not rented a book yet.</span></div>
    @else
        <div class="table-wrap"><table class="data-table"><thead><tr><th>Rental ID</th><th>Book</th><th>Rental Date</th><th>Return Date</th><th>Status</th></tr></thead><tbody>
        @foreach ($rentals as $rental)
            <tr><td><span class="table-id">#{{ $rental->rental_id }}</span></td><td><div class="book-identity compact"><a class="book-thumb tiny" href="{{ route('books.show', $rental->book) }}">@if ($rental->book->cover_url)<img src="{{ $rental->book->cover_url }}" alt="">@else<span>{{ strtoupper(substr($rental->book->title, 0, 1)) }}</span>@endif</a><a class="table-link" href="{{ route('books.show', $rental->book) }}">{{ $rental->book->title }}</a></div></td><td>{{ $rental->rental_date->format('M d, Y') }}</td><td>{{ $rental->return_date?->format('M d, Y') ?? '—' }}</td><td><span class="badge {{ $rental->status === 'Returned' ? 'success' : 'warning' }}">{{ $rental->status }}</span></td></tr>
        @endforeach
        </tbody></table></div>
        {{ $rentals->links('partials.pagination') }}
    @endif
</section>
@endsection
