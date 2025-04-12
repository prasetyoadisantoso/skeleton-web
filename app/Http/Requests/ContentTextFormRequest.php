<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule; // Import Rule

class ContentTextFormRequest extends FormRequest
{
    public $validator = null;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
        // Atau cek permission spesifik jika perlu
        // $routeName = Route::currentRouteName();
        // if ($routeName === 'content-text.bulk-destroy') {
        //     return auth()->user()->can('contenttext-destroy');
        // }
        // // ... cek permission lain ...
        // return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $route = Route::currentRouteName();
        $allowedTypes = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'paragraph']; // Definisikan tipe yang diizinkan

        switch ($route) {
            case 'content-text.store':
            case 'content-text.update': // Rules sama untuk store dan update
                return [
                    'type' => [
                        'required',
                        'string',
                        Rule::in($allowedTypes), // Gunakan Rule::in
                    ],
                    'content' => 'required|string', // Tambahkan max jika perlu, misal max:65535
                ];
                // break;

            case 'content-text.bulk-destroy':
                return [
                    'ids'   => 'required|array',
                    'ids.*' => 'required|uuid',
                ];
                // break;

            default:
                return [];
        }
    }

     /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        // Ambil dari file translation
        $trans = __('backend/contenttext.validation'); // Ganti nama file

        return [
            // Pesan untuk store/update
            'type.required' => $trans['type_required'] ?? 'The type field is required.',
            'type.string' => $trans['type_string'] ?? 'The type must be a string.',
            'type.in' => $trans['type_in'] ?? 'The selected type is invalid.',
            'content.required' => $trans['content_required'] ?? 'The content field is required.',
            'content.string' => $trans['content_string'] ?? 'The content must be a string.',
            // 'content.max' => $trans['content_max'] ?? 'The content may not be greater than :max characters.',

            // Pesan untuk bulk-destroy
            'ids.required' => $trans['ids_required'] ?? 'The selection field is required.',
            'ids.array' => $trans['ids_array'] ?? 'The selection must be an array.',
            'ids.*.required' => $trans['ids_item_required'] ?? 'Each selected item ID is required.',
            'ids.*.uuid' => $trans['ids_item_uuid'] ?? 'Each selected item must be a valid identifier.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }
}
