## 2.4.4 — Brand Lockup Refinement (2026-10-07)

- Refined the sidebar brand so the logo and lettering read as one balanced lockup.
- Increased the logo to 56px and removed the extra ring/border and shadow around the artwork.
- Kept `Book Rental System` on one line with improved weight, spacing, and vertical alignment.
- Refined the `Catalog & Transactions` subtitle for cleaner hierarchy and legibility.
- Widened the desktop sidebar to 272px so the brand has proper breathing room without crowding navigation.
- Updated the footer brand treatment to match the cleaner top branding.
- No database, catalog, borrower, or rental behavior changes.

## 2.4.2 — Clean Top Bar (2026-10-07)

- Removed the repeated page title and subtitle from the global top bar across Dashboard, Books, Borrowers, Rentals, detail pages, and forms.
- Kept only mobile navigation access plus the date and contextual New Rental action in the top bar.
- Main-content page headings remain the single source of page context, reducing duplicated labels and visual clutter.

## 2.4.1 — Catalog Header Cleanup (2026-10-07)

- Removed the redundant “Book collection / Media library” header from the Books media grid.
- The catalog now transitions directly from filters to book cards for a cleaner, more compact layout.

# Changelog

## Professional Catalog V2.4 — Media Catalog View — 2026-10-07

- Replaced the Books list/table with a cover-first responsive media grid.
- Book cards now prioritize cover art, title, author, year, price, availability, description, and rental-history context.
- Added compact overlay actions for View, Edit, and protected Delete without sacrificing the visual catalog layout.
- Added responsive 5/4/3/2-column behavior for desktop, tablet, and mobile screens.
- Increased book pagination from 10 to 12 items so grid pages remain visually balanced.
- Preserved all search, status filtering, sorting, cover uploads, details pages, rental logic, and delete protections.
- Added a new stylesheet cache token so the redesigned catalog appears immediately after update.

## Professional Catalog V2.3 — Book Stack Branding — 2026-10-07

- Replaced the previous system logo with the newly supplied book-stack-and-glasses artwork.
- Regenerated 16px/32px favicons, Apple touch icon, 192px/512px app icons, and multi-size `favicon.ico`.
- Refined sidebar logo containers for the circular transparent artwork.
- Added asset cache-busting so browsers immediately load the new branding after update.
- No database, catalog, borrower, rental, or business-logic changes.

## Professional Catalog V2.2 — System Branding — 2026-10-06

- Adopted the user-supplied book-search artwork as the official Book Rental System logo.
- Replaced the generic sidebar book glyph and footer initials with the official logo.
- Added browser favicon assets in ICO and PNG sizes plus an Apple touch icon.
- Added a canonical 512×512 logo and 192×192 application icon under `public/images/branding/`.
- Added cache-busting to the main stylesheet reference so the branding update appears immediately after deployment.

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

## 2.4.3 — Headerless Workspace (2026-10-07)
- Removed the global top header/topbar completely on desktop.
- Removed the date chip and duplicate global New Rental action from the header.
- Eliminated the blank heading strip so page content starts directly in the workspace.
- Preserved navigation on mobile with a compact floating menu button.
- Existing page-level actions and all catalog, borrower, and rental functionality are unchanged.
