<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class SchemaFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $route = Route::currentRouteName();

        switch ($route) {
            case 'schema.store':
                return [
                    'schema_type' => 'required|string|unique:schemas|max:50',
                    'schema_type' => 'required|string|max:50',
                    'schema_content' => 'required|json',
                    'posts' => 'nullable|array', // Validate the posts array
                    'posts.*' => 'uuid|exists:posts,id', // Validate each post ID
                ];
            case 'schema.update':
                return [
                    'schema_type' => 'required|string|max:50',
                    'schema_type' => 'required|string|max:50',
                    'schema_content' => 'required|json',
                    'posts' => 'nullable|array', // Validate the posts array
                    'posts.*' => 'uuid|exists:posts,id', // Validate each post ID
                ];
            default:
                return [];
        }
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'schema_content.json' => 'The schema content must be a valid JSON string.',
            'posts.*.exists' => 'The selected post is invalid.',
        ];
    }
}
