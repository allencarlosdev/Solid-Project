<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookCollectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:book_collections,name,NULL,id,user_id,' . auth()->id()
            ],
            'description' => 'nullable|string',
            'book_external_id' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la colección es requerido.',
            'name.unique' => 'Ya tienes una colección con este nombre.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
        ];
    }
}
