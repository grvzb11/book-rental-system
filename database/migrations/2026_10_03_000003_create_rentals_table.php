<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->bigIncrements('rental_id');
            $table->unsignedBigInteger('borrower_id');
            $table->unsignedBigInteger('book_id');
            $table->date('rental_date');
            $table->date('return_date')->nullable();
            $table->string('status')->default('Rented');

            $table->foreign('borrower_id')
                ->references('borrower_id')
                ->on('borrowers')
                ->onDelete('restrict');

            $table->foreign('book_id')
                ->references('book_id')
                ->on('books')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
