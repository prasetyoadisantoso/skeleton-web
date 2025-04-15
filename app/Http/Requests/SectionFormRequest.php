<?php

namespace App\Http\Requests; // Sesuaikan namespace jika perlu

use App\Models\Component; // Import model Component untuk validasi exists
use App\Models\Section; // Import model Section (opsional, bisa juga pakai string 'sections')
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule; // Import Rule untuk unique

class SectionFormRequest extends FormRequest
{
    /**
     * Properti untuk menyimpan instance validator jika validasi gagal.
     * Berguna untuk logging atau debugging.
     *
     * @var Validator|null
     */
    public $validator;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Hanya user yang terotentikasi yang boleh membuat request ini
        return auth()->check();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // 1. Decode JSON string 'components_order' menjadi array PHP
        $decodedComponents = json_decode($this->input('components_order', '[]'), true);

        // 2. Handle checkbox 'is_active'
        // Jika checkbox dicentang, nilainya 'on'. Jika tidak, nilainya null.
        // Konversi ke boolean true/false.
        $this->merge([
            // Pastikan hasil decode adalah array, jika tidak, jadikan array kosong
            'components_order' => is_array($decodedComponents) ? $decodedComponents : [],
            // Konversi 'on' atau adanya input 'is_active' menjadi boolean
            'is_active' => $this->input('is_active') === 'on' || $this->boolean('is_active'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $route = Route::currentRouteName();
        // Dapatkan ID section dari route parameter (untuk rule unique saat update)
        // Gunakan optional chaining (?) jika parameter 'section' mungkin tidak ada
        $sectionId = $this->route('section')?->id;

        // Aturan dasar yang berlaku untuk store dan update
        $baseRules = [
            'name' => [
                'required',
                'string',
                'max:255',
                // Rule unique:
                // - Saat store: unik di tabel sections kolom name
                // - Saat update: unik di tabel sections kolom name, kecuali untuk ID section saat ini
                Rule::unique('sections', 'name')->ignore($sectionId),
            ],
            'description' => 'nullable|string', // Deskripsi boleh kosong
            'layout_type' => 'required|string|max:50', // Tipe layout wajib diisi, maks 50 char
            'is_active' => 'required|boolean', // Status aktif wajib (setelah prepareForValidation)

            // Validasi untuk 'components_order' (setelah di-decode menjadi array)
            'components_order' => [
                'nullable', // Boleh null atau array kosong
                'array', // Harus berupa array
                // Custom rule menggunakan closure
                function ($attribute, $value, $fail) {
                    // Jika value bukan array (meskipun sudah dicek 'array', ini sbg pengaman tambahan)
                    if (!is_array($value)) {
                        return; // Keluar jika bukan array
                    }

                    $ids = []; // Untuk melacak ID komponen agar tidak duplikat
                    foreach ($value as $index => $item) {
                        // 1. Cek struktur item: harus array dan punya key 'id' & 'order'
                        if (!is_array($item) || !Arr::has($item, ['id', 'order'])) {
                            $fail("Setiap item dalam {$attribute} harus memiliki key 'id' dan 'order' pada index {$index}.");

                            return; // Hentikan validasi item ini jika struktur salah
                        }

                        // 2. Cek tipe data 'id': harus string dan format UUID
                        if (!is_string($item['id']) || !preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/i', $item['id'])) {
                            $fail("ID komponen '{$item['id']}' pada index {$index} dalam {$attribute} bukan format UUID yang valid.");
                        }

                        // 3. Cek tipe data 'order': harus integer dan tidak negatif
                        if (!is_int($item['order']) || $item['order'] < 0) {
                            $fail("Urutan '{$item['order']}' pada index {$index} dalam {$attribute} harus berupa angka integer non-negatif.");
                        }

                        // 4. Cek duplikasi ID dalam array 'components_order'
                        if (in_array($item['id'], $ids)) {
                            $fail("ID komponen duplikat '{$item['id']}' ditemukan dalam {$attribute}.");
                        }
                        $ids[] = $item['id']; // Tambahkan ID ke array pelacak
                    }

                    // 5. Cek apakah semua ID komponen yang diberikan ada di tabel 'components'
                    if (!empty($ids)) {
                        // Hitung jumlah ID unik yang ada di database
                        $existingIdsCount = Component::whereIn('id', $ids)->count();
                        // Jika jumlah yang ada di DB tidak sama dengan jumlah ID unik yang diberikan
                        if ($existingIdsCount !== count($ids)) {
                            // Cari ID mana yang tidak ada (opsional, untuk pesan error lebih detail)
                            $existingIds = Component::whereIn('id', $ids)->pluck('id')->all();
                            $nonExistingIds = array_diff($ids, $existingIds);
                            $fail('ID komponen berikut dalam '.$attribute.' tidak ditemukan di database: '.implode(', ', $nonExistingIds));
                        }
                    }
                },
            ],
        ];

        // Tentukan rules berdasarkan route
        switch ($route) {
            case 'section.store':
            case 'section.update':
                // Untuk store dan update, gunakan baseRules
                return $baseRules;

            case 'section.bulk-destroy':
                // Untuk bulk delete, validasi array 'ids'
                return [
                    'ids' => 'required|array', // 'ids' wajib ada dan berupa array
                    'ids.*' => [ // Setiap item dalam array 'ids'
                        'required', // Wajib ada
                        'uuid', // Harus format UUID
                        Rule::exists('sections', 'id'), // Harus ada di tabel 'sections' kolom 'id'
                    ],
                ];

            default:
                // Jika route tidak dikenali, kembalikan array kosong
                return [];
        }
    }

    /**
     * Get the custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        // Ambil terjemahan dari file lang (asumsi: lang/xx/backend/section.php)
        $trans = __('backend/section.validation'); // Ganti 'section' jika nama file berbeda

        return [
            // Pesan untuk base rules
            'name.required' => $trans['name_required'] ?? 'Kolom nama wajib diisi.',
            'name.string' => $trans['name_string'] ?? 'Nama harus berupa teks.',
            'name.max' => $trans['name_max'] ?? 'Nama tidak boleh lebih dari 255 karakter.',
            'name.unique' => $trans['name_unique'] ?? 'Nama ini sudah digunakan.',
            'description.string' => $trans['description_string'] ?? 'Deskripsi harus berupa teks.',
            'layout_type.required' => $trans['layout_type_required'] ?? 'Tipe layout wajib diisi.',
            'layout_type.string' => $trans['layout_type_string'] ?? 'Tipe layout harus berupa teks.',
            'layout_type.max' => $trans['layout_type_max'] ?? 'Tipe layout tidak boleh lebih dari 50 karakter.',
            'is_active.required' => $trans['is_active_required'] ?? 'Status aktif wajib diisi.',
            'is_active.boolean' => $trans['is_active_boolean'] ?? 'Status aktif harus berupa benar atau salah.',

            // Pesan untuk components_order
            'components_order.array' => $trans['components_order_array'] ?? 'Data urutan komponen harus berupa array.',
            // Pesan untuk custom rule closure akan ditampilkan dari $fail() di dalam closure

            // Pesan untuk bulk delete
            'ids.required' => $trans['ids_required'] ?? 'Kolom pilihan wajib diisi.',
            'ids.array' => $trans['ids_array'] ?? 'Pilihan harus berupa array.',
            'ids.*.required' => $trans['ids_item_required'] ?? 'Setiap ID item yang dipilih wajib diisi.',
            'ids.*.uuid' => $trans['ids_item_uuid'] ?? 'Setiap item yang dipilih harus berupa UUID yang valid.',
            'ids.*.exists' => $trans['ids_item_exists'] ?? 'Satu atau lebih item yang dipilih tidak ada di database.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        // Simpan instance validator ke properti $validator
        // Ini memungkinkan controller untuk mengakses error jika diperlukan (misalnya untuk logging)
        $this->validator = $validator;

        // Biarkan FormRequest melempar ValidationException seperti biasa
        parent::failedValidation($validator);
    }
}
