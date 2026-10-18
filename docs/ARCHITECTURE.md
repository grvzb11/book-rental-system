# Application Architecture

## Request flow

```text
Browser → Route → Controller → Model/Service → Database
                                   ↓
Browser ← Blade View ← Controller ← Result
```

## Responsibilities

### Models

`Book`, `Borrower`, and `Rental` represent the three required database entities. Relationships and reusable status/query helpers live here.

### Form Requests

`BookRequest`, `BorrowerRequest`, and `RentalRequest` contain input-validation rules. Keeping validation outside controllers makes controller methods easier to read.

### Controllers

Controllers coordinate HTTP requests and views. They prepare list filters, counts, and redirect messages but avoid containing the rent/return transaction implementation.

### RentalService

`RentalService` owns the core rental business rules:

- lock and verify the selected book
- create a rental only when the book is Available
- update the book to Rented in the same transaction
- mark a rental Returned and record the return date
- restore the book to Available in the same transaction

### Views

Blade views are grouped by feature. The shared `layouts/app.blade.php` provides navigation, top bar, alerts, and the reusable confirmation dialog.

### Frontend assets

`public/css/app.css` contains the complete responsive visual system. `public/js/app.js` handles the mobile sidebar, dismissible alerts, and confirmation dialog. No npm build is required.
