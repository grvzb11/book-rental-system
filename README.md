# Book Rental System — Professional Laravel MVC Edition

A compact Laravel MVC application for managing books, borrowers, rental transactions, and returns. The implementation keeps the assignment's required three-table domain (`books`, `borrowers`, and `rentals`) while organizing the application into focused Models, Form Requests, Controllers, a rental business service, Blade views, and local CSS/JavaScript.

## What is included

- Professional responsive dashboard and sidebar layout
- Book catalog CRUD with search, status filtering, pagination, availability metrics, and protected deletion when rental history exists
- Borrower CRUD with search, rental-history counts, active-rental indicators, and protected deletion
- Rental history with search, status filtering, date-range filtering, pagination, and return actions
- Rental workflow restricted to books with `Available` status
- Automatic `Available` → `Rented` and `Rented` → `Available` book-status transitions
- Automatic `Rented` → `Returned` rental transition and return-date recording
- Database transactions and row locks around rent/return operations
- Form Request validation for cleaner controllers
- `RentalService` for transaction/business logic
- Eloquent relationships, status constants, and reusable query scopes
- Responsive navigation, accessible form states, inline validation, confirmation dialog, empty states, and consistent UI components
- Local CSS and JavaScript only; no Node/npm frontend build is required
- Additional database indexes for common search/filter fields

## Requirements

- PHP 8.2+
- Composer
- MySQL/MariaDB or another Laravel-supported database
- Laravel 11 or 12 fresh project

## Installation

1. Create a Laravel project:

   ```bash
   composer create-project laravel/laravel book-rental-system
   cd book-rental-system
   ```

2. Copy these folders from this package into the Laravel project, replacing matching files:

   - `app/`
   - `database/`
   - `routes/`
   - `resources/`
   - `public/`

3. Configure `.env`:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=book_rental_system
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. Create the database `book_rental_system`.

5. Run migrations:

   ```bash
   php artisan migrate
   ```

6. Optional sample records:

   ```bash
   php artisan db:seed
   ```

7. Clear cached views/config after replacing an older version:

   ```bash
   php artisan optimize:clear
   ```

8. Start Laravel:

   ```bash
   php artisan serve
   ```

## Updating an existing copy

Copy the new `app`, `database`, `routes`, `resources`, and `public` files over your current Laravel project. Then run:

```bash
php artisan migrate
php artisan optimize:clear
```

The new migration only adds indexes; it does not replace or delete existing book, borrower, or rental data.

## Application structure

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── BookController.php
│   │   ├── BorrowerController.php
│   │   ├── DashboardController.php
│   │   └── RentalController.php
│   └── Requests/
│       ├── BookRequest.php
│       ├── BorrowerRequest.php
│       └── RentalRequest.php
├── Models/
│   ├── Book.php
│   ├── Borrower.php
│   └── Rental.php
└── Services/
    └── RentalService.php

resources/views/
├── layouts/
├── books/
├── borrowers/
├── rentals/
├── partials/
└── dashboard.blade.php

public/
├── css/app.css
└── js/app.js
```

## Important design decisions

Book status is not manually editable. It is controlled by rental and return transactions so the catalog cannot easily contradict the transaction history.

Books and borrowers that already have rental history cannot be deleted. This preserves foreign-key integrity and historical transaction records.

The rental service uses database transactions and `lockForUpdate()` so the rental record and book status change together and concurrent rental attempts cannot easily rent the same book twice.

## Documentation

- `docs/ARCHITECTURE.md` — how the application is organized
- `docs/DEMO_GUIDE.md` — recommended classroom demonstration flow
- `docs/REQUIREMENTS_TRACEABILITY.md` — assignment requirement mapping
- `docs/schema.sql` — reference SQL schema
- `docs/CHANGELOG.md` — improvements in this edition
