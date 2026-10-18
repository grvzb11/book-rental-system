@extends('layouts.app')
@section('title', 'Edit Borrower | Book Rental System')
@section('topbar_title', 'Edit Borrower')
@section('topbar_subtitle', 'Update borrower information')
@section('content')
<div class="page-heading"><div><div class="eyebrow">Directory</div><h1>Edit Borrower</h1><p>Update the contact information for <strong>{{ $borrower->name }}</strong>.</p></div></div>
<div class="form-layout">
    <section class="panel form-card"><form method="POST" action="{{ route('borrowers.update', $borrower) }}">@csrf @method('PUT') @include('borrowers.form')<div class="form-actions"><a class="btn ghost" href="{{ route('borrowers.index') }}">Cancel</a><button class="btn primary" type="submit">Save Changes</button></div></form></section>
    <aside class="form-aside"><span class="section-kicker">Record protection</span><h2>Rental history is preserved</h2><p>Borrowers with rental history cannot be deleted because their records are referenced by past transactions.</p></aside>
</div>
@endsection
