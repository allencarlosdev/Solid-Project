<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddBookToCollectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'book_external_id' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'book_external_id.required' => 'El ID del libro es requerido.',
            'book_external_id.string' => 'El ID del libro debe ser una cadena de texto.',
        ];
    }
}
