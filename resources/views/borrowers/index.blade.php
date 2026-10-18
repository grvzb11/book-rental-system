@extends('layouts.app')

@section('title', 'Borrowers | Book Rental System')
@section('topbar_title', 'Borrowers')
@section('topbar_subtitle', 'Borrower directory and rental activity')

@section('content')
<div class="page-heading split">
    <div><div class="eyebrow">Directory</div><h1>Borrowers</h1><p>Maintain borrower profiles and review their rental activity.</p></div>
    <a class="btn primary" href="{{ route('borrowers.create') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>Add Borrower</a>
</div>

<div class="page-metrics">
    <div><span>Registered Borrowers</span><strong>{{ $borrowerCount }}</strong></div>
    <div><span>With Active Rentals</span><strong class="text-warning">{{ $activeBorrowerCount }}</strong></div>
    <div><span>Total Rental Records</span><strong>{{ $totalRentalCount }}</strong></div>
</div>

<form method="GET" class="filter-bar single-search">
    <div class="search-field"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg><input type="search" name="search" value="{{ request('search') }}" placeholder="Search name or contact number" aria-label="Search borrowers"></div>
    <button class="btn secondary" type="submit">Search</button>
    @if (request('search'))<a class="btn ghost" href="{{ route('borrowers.index') }}">Clear</a>@endif
</form>

<section class="panel table-panel">
    <div class="panel-header table-panel-head"><div><span class="section-kicker">Borrower directory</span><h2>Registered borrowers</h2></div><span class="result-count">{{ $borrowers->total() }} {{ $borrowers->total() === 1 ? 'record' : 'records' }}</span></div>
    @if ($borrowers->isEmpty())
        <div class="empty-state"><div class="empty-icon">⌕</div><strong>No borrowers found</strong><span>Try another search or register a borrower.</span></div>
    @else
        <div class="table-wrap">
            <table class="data-table">
                <thead><tr><th>ID</th><th>Borrower</th><th>Contact Number</th><th>Rental History</th><th>Active</th><th class="actions-heading">Actions</th></tr></thead>
                <tbody>
                    @foreach ($borrowers as $borrower)
                        <tr>
                            <td><span class="table-id">#{{ $borrower->borrower_id }}</span></td>
                            <td><a class="person-cell person-link" href="{{ route('borrowers.show', $borrower) }}"><span class="person-avatar">{{ strtoupper(substr($borrower->name, 0, 1)) }}</span><strong>{{ $borrower->name }}</strong></a></td>
                            <td>{{ $borrower->contact_number }}</td>
                            <td>{{ $borrower->rentals_count }} {{ $borrower->rentals_count === 1 ? 'rental' : 'rentals' }}</td>
                            <td>@if ($borrower->active_rentals_count > 0)<span class="badge warning">{{ $borrower->active_rentals_count }} Active</span>@else<span class="muted-value">None</span>@endif</td>
                            <td class="actions-cell">
                                <div class="row-actions">
                                    <a class="icon-btn" href="{{ route('borrowers.show', $borrower) }}" title="View borrower" aria-label="View {{ $borrower->name }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12z"/><circle cx="12" cy="12" r="2.5"/></svg></a>
                                    <a class="icon-btn" href="{{ route('borrowers.edit', $borrower) }}" title="Edit borrower" aria-label="Edit {{ $borrower->name }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4z"/></svg></a>
                                    @if ($borrower->rentals_count === 0)
                                        <form action="{{ route('borrowers.destroy', $borrower) }}" method="POST" data-confirm="Delete {{ $borrower->name }}? This cannot be undone." data-confirm-title="Delete borrower">@csrf @method('DELETE')<button class="icon-btn danger" type="submit" title="Delete borrower" aria-label="Delete {{ $borrower->name }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="m19 6-1 14H6L5 6"/><path d="M10 11v5M14 11v5"/></svg></button></form>
                                    @else
                                        <button class="icon-btn disabled" type="button" disabled title="Cannot delete a borrower with rental history"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="m19 6-1 14H6L5 6"/></svg></button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $borrowers->links('partials.pagination') }}
    @endif
</section>
@endsection
