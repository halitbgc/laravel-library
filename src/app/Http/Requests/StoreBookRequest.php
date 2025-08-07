<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'string|max:1000',
            'author_id' => 'required|exists:authors,id',
            'published_year' => 'date',
            'genre_id' => 'required|exists:genres,id',
            'pages' => 'required|integer|min:1|max:10000',
        ];
    }
}
