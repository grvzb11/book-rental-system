<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'published_year' => ['required', 'integer', 'min:1000', 'max:' . now()->year],
            'price' => ['required', 'numeric', 'min:0', 'max:9999999.99'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'remove_cover' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'published_year' => 'published year',
            'cover_image' => 'book cover',
        ];
    }

    public function messages(): array
    {
        return [
            'cover_image.max' => 'The book cover must not be larger than 3 MB.',
            'cover_image.mimes' => 'The book cover must be a JPG, JPEG, PNG, or WebP image.',
        ];
    }
}
