# Requirements Traceability

| Assignment requirement | Implementation |
|---|---|
| Use Laravel framework | Laravel routes, controllers, Form Requests, Eloquent models, migrations, Blade views |
| Apply MVC | Models in `app/Models`, controllers in `app/Http/Controllers`, views in `resources/views` |
| Manage books | `BookController`, `BookRequest`, and `resources/views/books` |
| Manage borrowers | `BorrowerController`, `BorrowerRequest`, and `resources/views/borrowers` |
| Process rentals | `RentalController::store` delegates to `RentalService::rent` |
| Process returns | `RentalController::returnBook` delegates to `RentalService::return` |
| Borrower has many rentals | `Borrower::rentals()` |
| Book has many rental records | `Book::rentals()` |
| Rental belongs to borrower | `Rental::borrower()` |
| Rental belongs to book | `Rental::book()` |
| Rent only when Available | Available-only selector plus locked server-side validation in `RentalService::rent` |
| Renting changes book to Rented | Same database transaction in `RentalService::rent` |
| Returning changes book to Available | Same database transaction in `RentalService::return` |
| Returned rental records date/status | `return_date = today`, `status = Returned` |
