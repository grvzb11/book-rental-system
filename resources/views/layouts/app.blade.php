<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <meta name="theme-color" content="#111827">
    <title>@yield('title', 'Book Rental System')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}?v=2.4.4-brand-lockup" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/branding/favicon-32.png') }}?v=2.4.4-brand-lockup">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/branding/favicon-16.png') }}?v=2.4.4-brand-lockup">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/branding/apple-touch-icon.png') }}?v=2.4.4-brand-lockup">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=2.4.4-brand-lockup">
</head>
<body>
<div class="app-shell">
    <div class="sidebar-backdrop" data-sidebar-close></div>

    <aside class="sidebar" id="app-sidebar" aria-label="Main navigation">
        <div class="sidebar-head">
            <a href="{{ route('dashboard') }}" class="brand" aria-label="Book Rental System home">
                <span class="brand-mark" aria-hidden="true">
                    <img src="{{ asset('images/branding/book-rental-logo.png') }}?v=2.4.4-brand-lockup" alt="">
                </span>
                <span class="brand-copy">
                    <strong>Book Rental System</strong>
                    <span>Catalog & Transactions</span>
                </span>
            </a>
            <button class="sidebar-close" type="button" data-sidebar-close aria-label="Close navigation">×</button>
        </div>

        <div class="nav-section-label">Workspace</div>
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('books.index') }}" class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H11a3 3 0 0 1 3 3v15a3 3 0 0 0-3-3H6.5A2.5 2.5 0 0 0 4 20.5z"/><path d="M20 5.5A2.5 2.5 0 0 0 17.5 3H14v18a3 3 0 0 1 3-3h.5A2.5 2.5 0 0 1 20 20.5z"/></svg>
                <span>Books</span>
            </a>
            <a href="{{ route('borrowers.index') }}" class="nav-link {{ request()->routeIs('borrowers.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span>Borrowers</span>
            </a>
            <a href="{{ route('rentals.index') }}" class="nav-link {{ request()->routeIs('rentals.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 7h11l-2.5-2.5"/><path d="m18 7-2.5 2.5"/><path d="M17 17H6l2.5-2.5"/><path d="m6 17 2.5 2.5"/></svg>
                <span>Rentals</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-footer-mark" aria-hidden="true">
                <img src="{{ asset('images/branding/book-rental-logo.png') }}?v=2.4.4-brand-lockup" alt="">
            </div>
            <div>
                <strong>Book Rental System</strong>
                <span>Catalog workspace</span>
            </div>
        </div>
    </aside>

    <div class="app-main">
        <button class="mobile-menu-fab" type="button" data-sidebar-open aria-controls="app-sidebar" aria-label="Open navigation">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
        </button>

        <main class="content">
            @if (session('success'))
                <div class="alert success" role="status" data-alert>
                    <span class="alert-icon" aria-hidden="true">✓</span>
                    <div><strong>Success</strong><span>{{ session('success') }}</span></div>
                    <button type="button" class="alert-close" data-alert-close aria-label="Dismiss message">×</button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert error" role="alert" data-alert>
                    <span class="alert-icon" aria-hidden="true">!</span>
                    <div><strong>Action not completed</strong><span>{{ session('error') }}</span></div>
                    <button type="button" class="alert-close" data-alert-close aria-label="Dismiss message">×</button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert error" role="alert">
                    <span class="alert-icon" aria-hidden="true">!</span>
                    <div>
                        <strong>Please review the form</strong>
                        <span>{{ $errors->first() }}</span>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<dialog class="confirm-dialog" id="confirm-dialog">
    <div class="confirm-dialog-icon" aria-hidden="true">!</div>
    <div class="confirm-dialog-copy">
        <h2 id="confirm-title">Confirm action</h2>
        <p id="confirm-message">Are you sure you want to continue?</p>
    </div>
    <div class="confirm-dialog-actions">
        <button class="btn ghost" type="button" data-confirm-cancel>Cancel</button>
        <button class="btn danger-solid" type="button" data-confirm-accept>Continue</button>
    </div>
</dialog>

<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
