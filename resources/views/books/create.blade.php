@extends('layouts.app')
@section('title', 'Add Book | Book Rental System')
@section('topbar_title', 'Add Book')
@section('topbar_subtitle', 'Create a new catalog record')
@section('content')
<div class="page-heading"><div><div class="eyebrow">Catalog</div><h1>Add Book</h1><p>Create a complete catalog record with an optional book-cover image.</p></div></div>
<div class="form-layout">
    <section class="panel form-card">
        <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data">
            @csrf
            @include('books.form')
            <div class="form-actions"><a class="btn ghost" href="{{ route('books.index') }}">Cancel</a><button class="btn primary" type="submit">Save Book</button></div>
        </form>
    </section>
    <aside class="form-aside"><span class="section-kicker">Catalog quality</span><h2>Make records easy to recognize</h2><p>Add a clear <strong>cover image</strong>, accurate title and author, publication year, price, and a useful description. New books automatically start as <strong>Available</strong>.</p><div class="aside-tip"><strong>Cover tip</strong><span>Use a portrait image with the front cover visible. JPG, PNG and WebP are accepted up to 3 MB.</span></div></aside>
</div>
@endsection
