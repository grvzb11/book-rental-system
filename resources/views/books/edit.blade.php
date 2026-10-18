@extends('layouts.app')
@section('title', 'Edit Book | Book Rental System')
@section('topbar_title', 'Edit Book')
@section('topbar_subtitle', 'Update catalog information')
@section('content')
<div class="page-heading split"><div><div class="eyebrow">Catalog</div><h1>Edit Book</h1><p>Update the catalog details and cover for <strong>{{ $book->title }}</strong>.</p></div><a class="btn secondary" href="{{ route('books.show', $book) }}">View Book</a></div>
<div class="form-layout">
    <section class="panel form-card">
        <form method="POST" action="{{ route('books.update', $book) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('books.form')
            <div class="form-actions"><a class="btn ghost" href="{{ route('books.show', $book) }}">Cancel</a><button class="btn primary" type="submit">Save Changes</button></div>
        </form>
    </section>
    <aside class="form-aside"><span class="section-kicker">Record protection</span><h2>Availability stays transaction-driven</h2><p>You can update descriptive information and the cover image, but book status is controlled only by rental and return transactions to keep records consistent.</p></aside>
</div>
@endsection
