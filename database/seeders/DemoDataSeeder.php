<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Borrower;
use App\Models\Rental;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $borrowers = collect([
            ['name' => 'Juan Dela Cruz', 'contact_number' => '09170000001'],
            ['name' => 'Maria Santos', 'contact_number' => '09170000002'],
            ['name' => 'Andrea Reyes', 'contact_number' => '09170000003'],
            ['name' => 'Carlo Mendoza', 'contact_number' => '09170000004'],
            ['name' => 'Sofia Garcia', 'contact_number' => '09170000005'],
        ])->mapWithKeys(function (array $data) {
            $borrower = Borrower::firstOrCreate(
                ['name' => $data['name']],
                ['contact_number' => $data['contact_number']]
            );

            return [$data['name'] => $borrower];
        });

        $bookData = [
            [
                'title' => 'Noli Me Tangere',
                'author' => 'Jose Rizal',
                'description' => 'A landmark Filipino novel about social inequality, abuse of power, and the experiences of Filipinos under Spanish colonial rule.',
                'published_year' => 1887,
                'price' => 250.00,
                'cover_image' => 'uploads/books/demo-noli-me-tangere.svg',
            ],
            [
                'title' => 'El Filibusterismo',
                'author' => 'Jose Rizal',
                'description' => 'The darker sequel to Noli Me Tangere, following the return of Crisostomo Ibarra as Simoun and his pursuit of radical change.',
                'published_year' => 1891,
                'price' => 275.00,
                'cover_image' => 'uploads/books/demo-el-filibusterismo.svg',
            ],
            [
                'title' => 'The Little Prince',
                'author' => 'Antoine de Saint-Exupery',
                'description' => 'A reflective story about friendship, responsibility, wonder, and the way adults and children see the world differently.',
                'published_year' => 1943,
                'price' => 320.00,
                'cover_image' => 'uploads/books/demo-the-little-prince.svg',
            ],
            [
                'title' => 'Pride and Prejudice',
                'author' => 'Jane Austen',
                'description' => 'A classic novel centered on Elizabeth Bennet, family expectations, social class, first impressions, and personal growth.',
                'published_year' => 1813,
                'price' => 299.00,
                'cover_image' => 'uploads/books/demo-pride-and-prejudice.svg',
            ],
            [
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'description' => 'A novel of ambition, wealth, longing, and illusion set against the excess and social tensions of the Jazz Age.',
                'published_year' => 1925,
                'price' => 350.00,
                'cover_image' => 'uploads/books/demo-the-great-gatsby.svg',
            ],
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'description' => 'A dystopian novel exploring surveillance, propaganda, authoritarian control, truth, and individual freedom.',
                'published_year' => 1949,
                'price' => 399.00,
                'cover_image' => 'uploads/books/demo-1984.svg',
            ],
            [
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'description' => 'A coming-of-age novel that examines empathy, prejudice, justice, and moral courage through a child\'s perspective.',
                'published_year' => 1960,
                'price' => 420.00,
                'cover_image' => 'uploads/books/demo-to-kill-a-mockingbird.svg',
            ],
            [
                'title' => 'The Alchemist',
                'author' => 'Paulo Coelho',
                'description' => 'A philosophical adventure about a young shepherd pursuing a dream while learning about purpose, choice, and perseverance.',
                'published_year' => 1988,
                'price' => 380.00,
                'cover_image' => 'uploads/books/demo-the-alchemist.svg',
            ],
            [
                'title' => 'The Hobbit',
                'author' => 'J. R. R. Tolkien',
                'description' => 'A fantasy adventure following Bilbo Baggins as an unexpected journey challenges his courage, resourcefulness, and sense of home.',
                'published_year' => 1937,
                'price' => 450.00,
                'cover_image' => 'uploads/books/demo-the-hobbit.svg',
            ],
            [
                'title' => 'Charlotte\'s Web',
                'author' => 'E. B. White',
                'description' => 'A warm story about friendship, loyalty, change, and the bond between a pig named Wilbur and a spider named Charlotte.',
                'published_year' => 1952,
                'price' => 280.00,
                'cover_image' => 'uploads/books/demo-charlottes-web.svg',
            ],
        ];

        $books = collect($bookData)->mapWithKeys(function (array $data) {
            $book = Book::firstOrCreate(
                ['title' => $data['title'], 'author' => $data['author']],
                [
                    'description' => $data['description'],
                    'cover_image' => $data['cover_image'],
                    'published_year' => $data['published_year'],
                    'price' => $data['price'],
                    'status' => Book::STATUS_AVAILABLE,
                ]
            );

            // Older demo records may already exist from a previous release. Add only
            // missing presentation data without overwriting user-edited catalog values.
            $updates = [];
            if (! $book->cover_image) {
                $updates['cover_image'] = $data['cover_image'];
            }
            if (! $book->description || $book->description === 'Sample book record for testing.') {
                $updates['description'] = $data['description'];
            }
            if ($updates) {
                $book->update($updates);
            }

            return [$data['title'] => $book->fresh()];
        });

        $returnedRentals = [
            ['borrower' => 'Maria Santos', 'book' => 'El Filibusterismo', 'rental_date' => '2026-09-20', 'return_date' => '2026-09-28'],
            ['borrower' => 'Andrea Reyes', 'book' => 'The Great Gatsby', 'rental_date' => '2026-09-25', 'return_date' => '2026-10-01'],
            ['borrower' => 'Juan Dela Cruz', 'book' => 'Pride and Prejudice', 'rental_date' => '2026-09-15', 'return_date' => '2026-09-22'],
            ['borrower' => 'Sofia Garcia', 'book' => 'The Alchemist', 'rental_date' => '2026-09-29', 'return_date' => '2026-10-04'],
            ['borrower' => 'Maria Santos', 'book' => 'The Little Prince', 'rental_date' => '2026-09-30', 'return_date' => '2026-10-05'],
        ];

        foreach ($returnedRentals as $data) {
            Rental::firstOrCreate(
                [
                    'borrower_id' => $borrowers[$data['borrower']]->borrower_id,
                    'book_id' => $books[$data['book']]->book_id,
                    'rental_date' => $data['rental_date'],
                ],
                [
                    'return_date' => $data['return_date'],
                    'status' => Rental::STATUS_RETURNED,
                ]
            );
        }

        $activeRentals = [
            ['borrower' => 'Juan Dela Cruz', 'book' => 'Noli Me Tangere', 'rental_date' => '2026-10-04'],
            ['borrower' => 'Sofia Garcia', 'book' => '1984', 'rental_date' => '2026-10-05'],
            ['borrower' => 'Carlo Mendoza', 'book' => 'The Hobbit', 'rental_date' => '2026-10-06'],
        ];

        foreach ($activeRentals as $data) {
            $book = $books[$data['book']];

            // Never create two simultaneous active rentals for the same physical book.
            if (! Rental::where('book_id', $book->book_id)->active()->exists()) {
                Rental::firstOrCreate(
                    [
                        'borrower_id' => $borrowers[$data['borrower']]->borrower_id,
                        'book_id' => $book->book_id,
                        'rental_date' => $data['rental_date'],
                    ],
                    [
                        'return_date' => null,
                        'status' => Rental::STATUS_RENTED,
                    ]
                );
            }
        }

        // Keep catalog availability consistent with all active rentals, including
        // records that may already exist in the user's database.
        foreach ($books as $book) {
            $hasActiveRental = Rental::where('book_id', $book->book_id)->active()->exists();
            $expectedStatus = $hasActiveRental ? Book::STATUS_RENTED : Book::STATUS_AVAILABLE;

            if ($book->status !== $expectedStatus) {
                $book->update(['status' => $expectedStatus]);
            }
        }
    }
}
