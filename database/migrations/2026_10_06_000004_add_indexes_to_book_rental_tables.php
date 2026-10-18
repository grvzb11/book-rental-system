<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->index('status', 'books_status_index');
            $table->index('title', 'books_title_index');
            $table->index('author', 'books_author_index');
        });

        Schema::table('borrowers', function (Blueprint $table) {
            $table->index('name', 'borrowers_name_index');
        });

        Schema::table('rentals', function (Blueprint $table) {
            $table->index('status', 'rentals_status_index');
            $table->index('rental_date', 'rentals_rental_date_index');
            $table->index('return_date', 'rentals_return_date_index');
        });
    }

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropIndex('rentals_status_index');
            $table->dropIndex('rentals_rental_date_index');
            $table->dropIndex('rentals_return_date_index');
        });

        Schema::table('borrowers', function (Blueprint $table) {
            $table->dropIndex('borrowers_name_index');
        });

        Schema::table('books', function (Blueprint $table) {
            $table->dropIndex('books_status_index');
            $table->dropIndex('books_title_index');
            $table->dropIndex('books_author_index');
        });
    }
};
