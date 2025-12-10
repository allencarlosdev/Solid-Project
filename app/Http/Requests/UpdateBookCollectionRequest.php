<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookCollectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Safely get the collection ID from the route parameter
        $bookCollection = $this->route('bookCollection');
        $collectionId = $bookCollection ? $bookCollection->id : null;
        
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                $collectionId 
                    ? 'unique:book_collections,name,' . $collectionId . ',id,user_id,' . auth()->id()
                    : 'unique:book_collections,name,NULL,id,user_id,' . auth()->id()
            ],
            'description' => 'nullable|string',
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
