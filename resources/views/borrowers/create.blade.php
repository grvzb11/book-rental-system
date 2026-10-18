@extends('layouts.app')
@section('title', 'Add Borrower | Book Rental System')
@section('topbar_title', 'Add Borrower')
@section('topbar_subtitle', 'Register a new borrower profile')
@section('content')
<div class="page-heading"><div><div class="eyebrow">Directory</div><h1>Add Borrower</h1><p>Register a borrower before creating a rental transaction for them.</p></div></div>
<div class="form-layout">
    <section class="panel form-card"><form method="POST" action="{{ route('borrowers.store') }}">@csrf @include('borrowers.form')<div class="form-actions"><a class="btn ghost" href="{{ route('borrowers.index') }}">Cancel</a><button class="btn primary" type="submit">Save Borrower</button></div></form></section>
    <aside class="form-aside"><span class="section-kicker">Why this matters</span><h2>Borrowers connect to rentals</h2><p>Each rental transaction belongs to one registered borrower. Keeping borrower information accurate makes the rental history easy to trace.</p></aside>
</div>
@endsection
