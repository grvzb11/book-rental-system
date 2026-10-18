# Changelog

## Professional Catalog V2.1 — Demo Dataset — 2026-10-06

- Expanded the repeat-safe demo seeder from 2 borrowers/2 books to 5 fictional borrowers and 10 books.
- Added five completed rental transactions and up to three active rental transactions for a populated Dashboard and Rental History on first demonstration.
- Added original local SVG placeholder covers for all seeded books so the new catalog-cover interface is visible immediately.
- Added active-rental safeguards so re-running the seeder does not create a second simultaneous active rental for a demo book.
- Synchronizes each demo book's Available/Rented status against active rental records after seeding.
- Split demonstration data into `DemoDataSeeder` to keep `DatabaseSeeder` small and organized.


## Professional Catalog V2 — 2026-10-06

### Book catalog

- Added optional book-cover image upload for JPG, JPEG, PNG, and WebP files up to 3 MB.
- Added live cover preview, replace/remove controls, and automatic cleanup of replaced/deleted cover files.
- Added a dedicated Book Details page with cover, metadata, description, availability, and rental history.
- Added book-cover thumbnails to the catalog and rental history.
- Added catalog sorting by title, author, publication year, and price.
- Expanded book search to include descriptions.
- Added a selected-book preview to the New Rental form, including cover, author, year, and price.
- Added a description character counter.

### Borrowers and navigation

- Added a Borrower Details page with profile summary, active-rental count, completed count, and rental history.
- Added direct View actions and links between book, borrower, and rental records.

### Setup and reliability

- Added a migration for the optional `books.cover_image` enhancement without changing the assignment's required core fields.
- Updated installation guidance to use file-backed sessions/cache and synchronous queues for this small local academic project, avoiding unnecessary Laravel database infrastructure tables.

## Professional Redesign — 2026-10-06

- Rebuilt the visual system with a restrained professional layout and consistent spacing.
- Added responsive off-canvas navigation for smaller screens.
- Reworked Dashboard into clear statistics, catalog availability, quick actions, active rentals, and recent transactions.
- Added page-level metrics, search/filtering, pagination, protected deletion, confirmation dialogs, and responsive forms.
- Moved validation into Form Request classes and rent/return business transactions into `RentalService`.
- Added model status constants, query scopes, database indexes, and repeat-safe sample seeding.
