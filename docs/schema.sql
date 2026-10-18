CREATE TABLE borrowers (
    borrower_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    contact_number VARCHAR(255) NOT NULL,
    INDEX borrowers_name_index (name)
);

CREATE TABLE books (
    book_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    description TEXT NULL,
    published_year INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    status VARCHAR(255) NOT NULL DEFAULT 'Available',
    INDEX books_status_index (status),
    INDEX books_title_index (title),
    INDEX books_author_index (author)
);

CREATE TABLE rentals (
    rental_id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    borrower_id BIGINT UNSIGNED NOT NULL,
    book_id BIGINT UNSIGNED NOT NULL,
    rental_date DATE NOT NULL,
    return_date DATE NULL,
    status VARCHAR(255) NOT NULL DEFAULT 'Rented',
    CONSTRAINT rentals_borrower_id_foreign FOREIGN KEY (borrower_id)
        REFERENCES borrowers (borrower_id) ON DELETE RESTRICT,
    CONSTRAINT rentals_book_id_foreign FOREIGN KEY (book_id)
        REFERENCES books (book_id) ON DELETE RESTRICT,
    INDEX rentals_status_index (status),
    INDEX rentals_rental_date_index (rental_date),
    INDEX rentals_return_date_index (return_date)
);
