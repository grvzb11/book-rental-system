@extends('layouts.app')

@section('title', 'Rentals | Book Rental System')
@section('topbar_title', 'Rentals')
@section('topbar_subtitle', 'Checkout and return transaction history')

@section('content')
<div class="page-heading split">
    <div><div class="eyebrow">Transactions</div><h1>Rentals</h1><p>Track active checkouts, completed returns, and the complete rental history.</p></div>
    <a class="btn primary" href="{{ route('rentals.create') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>New Rental</a>
</div>

<div class="page-metrics">
    <div><span>Total Transactions</span><strong>{{ $totalRentalCount }}</strong></div>
    <div><span>Active Rentals</span><strong class="text-warning">{{ $activeRentalCount }}</strong></div>
    <div><span>Returned</span><strong class="text-success">{{ $returnedCount }}</strong></div>
</div>

<form method="GET" class="filter-bar rental-filters">
    <div class="search-field"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg><input type="search" name="search" value="{{ request('search') }}" placeholder="Search borrower, title, or author" aria-label="Search rentals"></div>
    <select name="status" aria-label="Filter rentals by status"><option value="">All statuses</option><option value="Rented" @selected(request('status') === 'Rented')>Rented</option><option value="Returned" @selected(request('status') === 'Returned')>Returned</option></select>
    <div class="date-filter"><label for="from">From</label><input id="from" type="date" name="from" value="{{ request('from') }}"></div>
    <div class="date-filter"><label for="to">To</label><input id="to" type="date" name="to" value="{{ request('to') }}"></div>
    <button class="btn secondary" type="submit">Apply</button>
    @if (request()->hasAny(['search', 'status', 'from', 'to']))<a class="btn ghost" href="{{ route('rentals.index') }}">Clear</a>@endif
</form>

<section class="panel table-panel">
    <div class="panel-header table-panel-head"><div><span class="section-kicker">Transaction history</span><h2>Rental records</h2></div><span class="result-count">{{ $rentals->total() }} {{ $rentals->total() === 1 ? 'record' : 'records' }}</span></div>
    @if ($rentals->isEmpty())
        <div class="empty-state"><div class="empty-icon">↔</div><strong>No rental records found</strong><span>Create a rental or adjust the filters.</span></div>
    @else
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>Rental</th><th>Borrower</th><th>Book</th><th>Rented On</th><th>Returned On</th><th>Status</th><th class="actions-heading">Action</th></tr></thead>
                <tbody>
                    @foreach ($rentals as $rental)
                        <tr>
                            <td><span class="table-id">#{{ $rental->rental_id }}</span></td>
                            <td><a class="person-cell person-link" href="{{ route('borrowers.show', $rental->borrower) }}"><span class="person-avatar small">{{ strtoupper(substr($rental->borrower->name, 0, 1)) }}</span><strong>{{ $rental->borrower->name }}</strong></a></td>
                            <td class="book-cell"><div class="book-identity compact"><a class="book-thumb tiny" href="{{ route('books.show', $rental->book) }}">@if ($rental->book->cover_url)<img src="{{ $rental->book->cover_url }}" alt="">@else<span>{{ strtoupper(substr($rental->book->title, 0, 1)) }}</span>@endif</a><div><a class="book-title-link" href="{{ route('books.show', $rental->book) }}">{{ $rental->book->title }}</a><span>{{ $rental->book->author }}</span></div></div></td>
                            <td>{{ $rental->rental_date->format('M d, Y') }}</td>
                            <td>{{ $rental->return_date?->format('M d, Y') ?? '—' }}</td>
                            <td><span class="badge {{ $rental->status === 'Returned' ? 'success' : 'warning' }}">{{ $rental->status }}</span></td>
                            <td class="actions-cell">
                                @if ($rental->status === 'Rented')
                                    <form action="{{ route('rentals.return', $rental) }}" method="POST" data-confirm="Mark “{{ $rental->book->title }}” as returned? The book will become available again." data-confirm-title="Return book">@csrf<button class="btn small success" type="submit">Return</button></form>
                                @else
                                    <span class="completed-label">Completed</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $rentals->links('partials.pagination') }}
    @endif
</section>
@endsection
