<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
use App\Models\ContentText;
use App\Models\ContentImage;

class ComponentFormRequest extends FormRequest
{
    public $validator = null;

    public function authorize(): bool
    {
        return auth()->check();
    }

    protected function prepareForValidation()
    {
        $decodedImages = json_decode($this->input('content_images_order', '[]'), true);
        $decodedTexts = json_decode($this->input('content_texts_order', '[]'), true); // <-- Decode text order

        $this->merge([
            'content_images_order' => is_array($decodedImages) ? $decodedImages : [],
            'content_texts_order' => is_array($decodedTexts) ? $decodedTexts : [], // <-- Merge decoded texts
            'is_active' => $this->input('is_active') === 'on',
        ]);
    }

    public function rules(): array
    {
        $route = Route::currentRouteName();
        $componentId = $this->route('component');

        $baseRules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',

            // Validasi Content Images Order (Array)
            'content_images_order' => [
                'nullable',
                'array',
                function ($attribute, $value, $fail) {
                    if (!is_array($value)) return; // Sudah dicek rule 'array'
                    $ids = [];
                    foreach ($value as $index => $item) {
                        if (!is_array($item) || !Arr::has($item, ['id', 'order'])) {
                            $fail("Each item in {$attribute} must have 'id' and 'order' keys at index {$index}."); return;
                        }
                        if (!is_string($item['id']) || !preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/i', $item['id'])) {
                             $fail("The image id '{$item['id']}' at index {$index} in {$attribute} is not a valid UUID.");
                        }
                        if (!is_int($item['order']) || $item['order'] < 0) {
                            $fail("The order '{$item['order']}' at index {$index} in {$attribute} must be a non-negative integer.");
                        }
                        if (in_array($item['id'], $ids)) {
                            $fail("Duplicate content image ID '{$item['id']}' found in {$attribute}.");
                        }
                        $ids[] = $item['id'];
                    }
                    if (!empty($ids)) {
                        $existingIds = \App\Models\ContentImage::whereIn('id', $ids)->pluck('id')->all();
                        $nonExistingIds = array_diff($ids, $existingIds);
                        if (!empty($nonExistingIds)) {
                             $fail('The following content image IDs in '.$attribute.' do not exist: '.implode(', ', $nonExistingIds));
                        }
                    }
                },
            ],

            // Validasi Content Texts Order (Array) <-- Tambahkan blok ini
            'content_texts_order' => [
                'nullable',
                'array',
                function ($attribute, $value, $fail) {
                    if (!is_array($value)) return; // Sudah dicek rule 'array'
                    $ids = [];
                    foreach ($value as $index => $item) {
                        if (!is_array($item) || !Arr::has($item, ['id', 'order'])) {
                            $fail("Each item in {$attribute} must have 'id' and 'order' keys at index {$index}."); return;
                        }
                        if (!is_string($item['id']) || !preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/i', $item['id'])) {
                             $fail("The text id '{$item['id']}' at index {$index} in {$attribute} is not a valid UUID.");
                        }
                        if (!is_int($item['order']) || $item['order'] < 0) {
                            $fail("The order '{$item['order']}' at index {$index} in {$attribute} must be a non-negative integer.");
                        }
                        if (in_array($item['id'], $ids)) {
                            $fail("Duplicate content text ID '{$item['id']}' found in {$attribute}.");
                        }
                        $ids[] = $item['id'];
                    }
                    if (!empty($ids)) {
                        $existingIds = \App\Models\ContentText::whereIn('id', $ids)->pluck('id')->all(); // <-- Model ContentText
                        $nonExistingIds = array_diff($ids, $existingIds);
                        if (!empty($nonExistingIds)) {
                             $fail('The following content text IDs in '.$attribute.' do not exist: '.implode(', ', $nonExistingIds));
                        }
                    }
                },
            ],

            // Hapus validasi 'content_text_ids' jika tidak lagi menggunakan select multiple biasa
            // 'content_text_ids'    => 'nullable|array',
            // 'content_text_ids.*'  => ['required', 'uuid', Rule::exists('content_texts', 'id')],
        ];

        // ... (switch $route untuk rules spesifik store/update/bulk) ...
        switch ($route) {
            case 'component.store':
            case 'component.update':
                return $baseRules;
            case 'component.bulk-destroy':
                 return [
                    'ids' => 'required|array',
                    'ids.*' => ['required', 'uuid', Rule::exists('components', 'id')],
                ];
            default:
                return [];
        }
    }

    public function messages(): array
    {
        $trans = __('backend/component.validation'); // Ganti path jika perlu

        return [
            'name.required' => $trans['name_required'] ?? 'The name field is required.',
            'name.string' => $trans['name_string'] ?? 'The name must be a string.',
            'name.max' => $trans['name_max'] ?? 'The name may not be greater than 255 characters.',
            'description.string' => $trans['description_string'] ?? 'The description must be a string.',
            'is_active.required' => $trans['is_active_required'] ?? 'The active status field is required.',
            'is_active.boolean' => $trans['is_active_boolean'] ?? 'The active status must be true or false.',

            'content_images_order.array' => $trans['content_images_order_array'] ?? 'The content images order data must be structured as an array.',
            // Pesan custom rule gambar dari $fail()

            'content_texts_order.array' => $trans['content_texts_order_array'] ?? 'The content texts order data must be structured as an array.', // <-- Tambahkan pesan
            // Pesan custom rule text dari $fail()

            'ids.required' => $trans['ids_required'] ?? 'The selection field is required.',
            'ids.array' => $trans['ids_array'] ?? 'The selection must be an array.',
            'ids.*.required' => $trans['ids_item_required'] ?? 'Each selected item ID is required.',
            'ids.*.uuid' => $trans['ids_item_uuid'] ?? 'Each selected item must be a valid identifier.',
            'ids.*.exists' => $trans['ids_item_exists'] ?? 'One or more selected items do not exist.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }
}
