<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // <-- Pastikan ini di-import
use Illuminate\Support\Facades\Log; // <-- Import Log jika masih dipakai untuk debug

class LayoutFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Sesuaikan dengan logic otorisasi Anda
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        // Log data mentah SEBELUM validasi dimulai
        Log::debug('LayoutFormRequest - Raw Input Data:', $this->all());

        return [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(['full-width', 'sidebar'])],

            // --- Main Sections ---
            'sections_main' => ['nullable', 'array'], // Boleh null atau array
            // Jika ada item di sections_main, ID WAJIB ADA di item itu
            'sections_main.*.id' => [
                'required', // <--- UBAH INI: Cukup 'required'
                'uuid',
                'exists:sections,id'
            ],
            // Jika ada item di sections_main, ORDER WAJIB ADA di item itu
            'sections_main.*.order' => [
                'required', // <--- UBAH INI: Cukup 'required'
                'integer',
                'min:0'
            ],

            // --- Sidebar Sections (KONDISIONAL - Ini sudah benar) ---
            'sections_sidebar' => [
                Rule::requiredIf(fn () => $this->input('type') === 'sidebar'),
                'nullable',
                'array'
            ],
            'sections_sidebar.*.id' => [
                Rule::requiredIf(fn () => $this->input('type') === 'sidebar'),
                'uuid',
                'exists:sections,id'
            ],
            'sections_sidebar.*.order' => [
                 Rule::requiredIf(fn () => $this->input('type') === 'sidebar'),
                'integer',
                'min:0'
            ],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        // Tambahkan nama atribut yang lebih user-friendly jika perlu
        return [
            'sections_main.*.id' => 'main section ID',
            'sections_main.*.order' => 'main section order',
            'sections_sidebar.*.id' => 'sidebar section ID',
            'sections_sidebar.*.order' => 'sidebar section order',
        ];
    }
}
