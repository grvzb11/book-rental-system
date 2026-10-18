# Demo Guide

## Prepare the presentation data

Run:

```bash
php artisan db:seed
php artisan optimize:clear
```

This prepares a populated catalog, five fictional borrowers, returned-rental history, and active rentals. It is safe to run again if you already seeded an older release.

## Suggested demonstration

1. Open **Dashboard** and explain that the counts are calculated from the live Books, Borrowers, and Rentals data.
2. Open **Books**. Demonstrate search, status filtering, sorting, and cover thumbnails.
3. Choose **Add Book**, upload an optional cover, enter the required book information, and save. Point out that status is automatically `Available`.
4. Open the new **Book Details** page and show its cover, metadata, description, availability, and empty rental history.
5. Open **Borrowers**, add a borrower, then open the new **Borrower Details** page.
6. Choose **New Rental**. Select the borrower and the book. Show how the selected-book preview confirms the title/cover before submission.
7. Submit the rental. Explain that the rental record becomes `Rented` and the book changes from `Available` to `Rented` in one transaction.
8. Return to the Book Details page and show that its rental history now identifies the borrower.
9. Open **Rentals** and return the book. Explain that the rental becomes `Returned`, `return_date` is recorded, and the book becomes `Available` again.
10. End by showing `routes/web.php`, the three Models, Controllers, Form Requests, `RentalService`, `BookCoverService`, migrations, and Blade views to explain MVC organization.