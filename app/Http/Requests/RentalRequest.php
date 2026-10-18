<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RentalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'borrower_id' => ['required', 'integer', 'exists:borrowers,borrower_id'],
            'book_id' => ['required', 'integer', 'exists:books,book_id'],
            'rental_date' => ['required', 'date', 'before_or_equal:today'],
        ];
    }

    public function attributes(): array
    {
        return [
            'borrower_id' => 'borrower',
            'book_id' => 'book',
            'rental_date' => 'rental date',
        ];
    }
}
