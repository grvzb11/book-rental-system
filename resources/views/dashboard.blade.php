@extends('layouts.app')

@section('title', 'Dashboard | Book Rental System')
@section('topbar_title', 'Dashboard')
@section('topbar_subtitle', 'Overview of catalog and rental activity')

@section('content')
<div class="page-heading">
    <div>
        <div class="eyebrow">Overview</div>
        <h1>Dashboard</h1>
        <p>Monitor availability, borrower activity, and recent transactions from one place.</p>
    </div>
</div>

<section class="stats-grid" aria-label="System summary">
    <article class="stat-card">
        <div class="stat-icon blue" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H11a3 3 0 0 1 3 3v15a3 3 0 0 0-3-3H6.5A2.5 2.5 0 0 0 4 20.5z"/><path d="M20 5.5A2.5 2.5 0 0 0 17.5 3H14v18a3 3 0 0 1 3-3h.5A2.5 2.5 0 0 1 20 20.5z"/></svg></div>
        <div class="stat-body"><span>Total Books</span><strong>{{ $bookCount }}</strong><small>Catalog records</small></div>
    </article>
    <article class="stat-card">
        <div class="stat-icon green" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12 4 4L19 6"/></svg></div>
        <div class="stat-body"><span>Available</span><strong>{{ $availableCount }}</strong><small>{{ $availabilityRate }}% of catalog</small></div>
    </article>
    <article class="stat-card">
        <div class="stat-icon amber" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></div>
        <div class="stat-body"><span>Active Rentals</span><strong>{{ $rentedCount }}</strong><small>Currently checked out</small></div>
    </article>
    <article class="stat-card">
        <div class="stat-icon violet" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/></svg></div>
        <div class="stat-body"><span>Borrowers</span><strong>{{ $borrowerCount }}</strong><small>Registered profiles</small></div>
    </article>
</section>

<div class="dashboard-grid">
    <section class="panel catalog-health">
        <div class="panel-header">
            <div><span class="section-kicker">Catalog availability</span><h2>Collection status</h2></div>
            <span class="metric-pill">{{ $availabilityRate }}% available</span>
        </div>
        <div class="availability-copy">
            <strong>{{ $availableCount }} available</strong>
            <span>out of {{ $bookCount }} total {{ $bookCount === 1 ? 'book' : 'books' }}</span>
        </div>
        <div class="progress-track" role="progressbar" aria-label="Book availability" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $availabilityRate }}">
            <span style="width: {{ $availabilityRate }}%"></span>
        </div>
        <div class="legend-row"><span><i class="legend-dot available"></i>{{ $availableCount }} Available</span><span><i class="legend-dot rented"></i>{{ $rentedCount }} Rented</span></div>
        <div class="mini-metrics">
            <div><span>Total Rentals</span><strong>{{ $totalRentalCount }}</strong></div>
            <div><span>Returned</span><strong>{{ $returnedCount }}</strong></div>
            <div><span>Rented Today</span><strong>{{ $todayRentalCount }}</strong></div>
            <div><span>Returned Today</span><strong>{{ $todayReturnCount }}</strong></div>
        </div>
    </section>

    <section class="panel quick-panel">
        <div class="panel-header"><div><span class="section-kicker">Shortcuts</span><h2>Quick actions</h2></div></div>
        <div class="quick-list">
            <a href="{{ route('rentals.create') }}"><span class="quick-icon">↔</span><span><strong>New Rental</strong><small>Check out an available book</small></span><b>→</b></a>
            <a href="{{ route('books.create') }}"><span class="quick-icon">+</span><span><strong>Add Book</strong><small>Create a new catalog record</small></span><b>→</b></a>
            <a href="{{ route('borrowers.create') }}"><span class="quick-icon">+</span><span><strong>Add Borrower</strong><small>Register a borrower profile</small></span><b>→</b></a>
        </div>
    </section>
</div>

<div class="dashboard-grid lower">
    <section class="panel">
        <div class="panel-header">
            <div><span class="section-kicker">Current checkouts</span><h2>Active rentals</h2></div>
            <a class="text-link" href="{{ route('rentals.index', ['status' => 'Rented']) }}">View all →</a>
        </div>
        @if ($activeRentals->isEmpty())
            <div class="empty-state compact-empty"><div class="empty-icon">✓</div><strong>No active rentals</strong><span>All books are currently returned.</span></div>
        @else
            <div class="record-list">
                @foreach ($activeRentals as $rental)
                    <div class="record-row">
                        <a class="record-cover" href="{{ route('books.show', $rental->book) }}">@if ($rental->book->cover_url)<img src="{{ $rental->book->cover_url }}" alt="">@else<span>{{ strtoupper(substr($rental->book->title, 0, 1)) }}</span>@endif</a>
                        <div class="record-main"><a href="{{ route('books.show', $rental->book) }}"><strong>{{ $rental->book->title }}</strong></a><span><a class="inline-link" href="{{ route('borrowers.show', $rental->borrower) }}">{{ $rental->borrower->name }}</a> · {{ $rental->rental_date->format('M d, Y') }}</span></div>
                        <form action="{{ route('rentals.return', $rental) }}" method="POST" data-confirm="Mark this book as returned?" data-confirm-title="Return book">
                            @csrf
                            <button class="btn small success" type="submit">Return</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <section class="panel">
        <div class="panel-header">
            <div><span class="section-kicker">History</span><h2>Recent transactions</h2></div>
            <a class="text-link" href="{{ route('rentals.index') }}">View all →</a>
        </div>
        @if ($recentRentals->isEmpty())
            <div class="empty-state compact-empty"><div class="empty-icon">↔</div><strong>No transactions yet</strong><span>Rental activity will appear here.</span></div>
        @else
            <div class="record-list">
                @foreach ($recentRentals as $rental)
                    <div class="record-row">
                        <a class="record-cover" href="{{ route('books.show', $rental->book) }}">@if ($rental->book->cover_url)<img src="{{ $rental->book->cover_url }}" alt="">@else<span>{{ strtoupper(substr($rental->book->title, 0, 1)) }}</span>@endif</a>
                        <div class="record-main"><a href="{{ route('books.show', $rental->book) }}"><strong>{{ $rental->book->title }}</strong></a><span><a class="inline-link" href="{{ route('borrowers.show', $rental->borrower) }}">{{ $rental->borrower->name }}</a> · #{{ $rental->rental_id }}</span></div>
                        <span class="badge {{ $rental->status === 'Returned' ? 'success' : 'warning' }}">{{ $rental->status }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
</div>
@endsection
