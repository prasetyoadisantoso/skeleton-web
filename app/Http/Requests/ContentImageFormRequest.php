<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator; // Import Validator
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route; // Import Route

class ContentImageFormRequest extends FormRequest
{
    public $validator; // Tambahkan properti ini seperti di MediaLibraryFormRequest

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Pastikan user terotentikasi
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $route = Route::currentRouteName(); // Dapatkan nama route saat ini

        switch ($route) {
            case 'content-image.store': // Gunakan nama route untuk store
                return [
                    // Name required, max 255 (sesuaikan jika perlu)
                    'name' => 'required|string|max:255',
                    // Media file required saat store, validasi image
                    'media_file' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:5120', // Max 5MB
                    // Alt text required
                    'alt_text' => 'required|string|max:255',
                    // Caption nullable
                    'caption' => 'nullable|string|max:1000',
                ];
                // Tidak perlu break setelah return

            case 'content-image.update': // Gunakan nama route untuk update
                return [
                    // Name required, max 255 (sesuaikan jika perlu)
                    'name' => 'required|string|max:255',
                    // Media file nullable saat update, validasi image jika ada
                    'media_file' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:5120', // Max 5MB
                    // Alt text required
                    'alt_text' => 'required|string|max:255',
                    // Caption nullable
                    'caption' => 'nullable|string|max:1000',
                ];
                // Tidak perlu break setelah return

            case 'content-image.bulk-destroy': // <-- CASE BARU
                return [
                    'ids' => 'required|array', // Pastikan 'ids' ada dan berupa array
                    'ids.*' => 'required|uuid', // Pastikan setiap item dalam array 'ids' ada dan berupa UUID
                ];

            default:
                // Default rules kosong jika route tidak cocok
                return [];
        }
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        // Ambil dari file translation jika sudah dibuat
        $trans = __('backend/contentimage.validation'); // Sesuaikan path

        // Pastikan ada pesan untuk 'name' juga
        return [
            'name.required' => $trans['name_required'] ?? 'The name field is required.',
            'name.max' => $trans['name_max'] ?? 'The name may not be greater than 255 characters.',
            'media_file.required' => $trans['media_file_required'] ?? 'The image file field is required.', // Gunakan 'media_file' sesuai input name
            'media_file.image' => $trans['media_file_image'] ?? 'The file must be an image.',
            'media_file.mimes' => $trans['media_file_mimes'] ?? 'The image must be a file of type: jpg, jpeg, png, webp, gif.',
            'media_file.max' => $trans['media_file_max'] ?? 'The image may not be greater than 5120 kilobytes.',
            'alt_text.required' => $trans['alt_text_required'] ?? 'The alt text field is required.',
            'alt_text.max' => $trans['alt_text_max'] ?? 'The alt text may not be greater than 255 characters.',
            'caption.max' => $trans['caption_max'] ?? 'The caption may not be greater than 1000 characters.',

            // Pesan untuk bulk-destroy (BARU)
            'ids.required' => $trans['ids_required'] ?? 'The selection field is required.',
            'ids.array' => $trans['ids_array'] ?? 'The selection must be an array.',
            'ids.*.required' => $trans['ids_item_required'] ?? 'Each selected item ID is required.',
            'ids.*.uuid' => $trans['ids_item_uuid'] ?? 'Each selected item must be a valid identifier.',
        ];
    }

    // Tambahkan method ini seperti di MediaLibraryFormRequest
    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }
}
