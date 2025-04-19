<?php

namespace App\Models; // Sesuaikan namespace jika berbeda (misal: App\Models\Template)

// Hapus: use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr; // <-- Tambahkan Arr
use Spatie\Translatable\HasTranslations; // <-- Tambahkan HasTranslations
use Webpatser\Uuid\Uuid; // <-- Tambahkan Uuid dari Webpatser

// Import model Component dengan namespace yang benar
// Asumsi Component ada di App\Models

class Section extends Model
{
    use HasFactory;
    use HasTranslations; // <-- Gunakan trait HasTranslations
    // Hapus: use HasUuids;

    public $incrementing = false; // <-- Tambahkan: Non-incrementing primary key
    protected $primaryKey = 'id'; // <-- Tambahkan: Tentukan primary key

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'layout_type',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        // 'layout_options' => 'array', // Aktifkan jika Anda menyimpan layout_options sebagai JSON
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    protected $translatable = ['description']; // <-- Tambahkan: Jadikan description translatable

    /**
     * Boot function from Laravel.
     * Menggunakan Webpatser Uuid untuk generate ID.
     */
    protected static function boot() // <-- Tambahkan boot method
    {
        parent::boot();
        static::creating(function ($model) {
            // Gunakan getKeyName() untuk fleksibilitas jika primary key berubah
            $model->{$model->getKeyName()} = (string) Uuid::generate(4);
        });
    }

    public function layouts()
    {
        return $this->belongsToMany(Layout::class, 'layout_section', 'section_id', 'layout_id')
            ->withPivot('location', 'order')
            ->orderBy('layout_section.order');
    }

    /**
     * The components that belong to the section.
     * Mendefinisikan relasi Many-to-Many ke Component.
     */
    public function components()
    {
        // Parameter kedua adalah nama tabel pivot
        // Parameter ketiga (opsional) adalah foreign key model ini di tabel pivot ('section_id')
        // Parameter keempat (opsional) adalah foreign key model relasi di tabel pivot ('component_id')
        return $this->belongsToMany(Component::class, 'component_section', 'section_id', 'component_id')
                    ->withPivot('order') // Mengambil kolom 'order' dari tabel pivot
                    ->orderBy('pivot_order', 'asc'); // Mengurutkan komponen berdasarkan kolom 'order' di pivot
    }

    /**
     * Scope a query to only include active sections.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // --- Optional CRUD Helper Methods (mengikuti pola Component.php) ---

    /**
     * Get Section by ID with its components.
     *
     * @param string|null $id UUID
     */
    public function getSectionById(?string $id = null): ?Section
    {
        // Eager load relasi 'components'
        return $this->with('components')->find($id);
    }

    /**
     * Get Section query builder.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getSectionsQuery()
    {
        return $this->query();
    }

    /**
     * Store a new Section and sync components.
     *
     * @param array $data Validated data (sudah termasuk 'components_order' yang di-decode)
     */
    public function storeSection(array $data): Section
    {
        // Pisahkan data section dari data relasi
        $sectionData = Arr::only($data, $this->getFillable()); // Gunakan Arr::only
        // Ambil data order komponen (sudah berupa array dari controller)
        $componentsOrder = Arr::get($data, 'components_order', []); // Gunakan Arr::get

        // Buat section baru
        $section = $this->create($sectionData);

        // Siapkan data untuk sync
        $syncData = $this->prepareSyncDataWithOrder($componentsOrder);

        // Sync Components
        if (!empty($syncData)) {
            $section->components()->sync($syncData);
        } else {
            $section->components()->detach(); // Hapus semua jika tidak ada order
        }

        return $section;
    }

    /**
     * Update an existing Section and sync components.
     *
     * @param string $id   UUID
     * @param array  $data Validated data (sudah termasuk 'components_order' yang di-decode)
     */
    public function updateSection(string $id, array $data): ?Section
    {
        $section = $this->find($id);
        if ($section) {
            // Pisahkan data section
            $sectionData = Arr::only($data, $this->getFillable()); // Gunakan Arr::only
            // Ambil data order komponen (sudah berupa array dari controller)
            $componentsOrder = Arr::get($data, 'components_order', []); // Gunakan Arr::get

            // Update data section
            $section->update($sectionData);

            // Siapkan data sync
            $syncData = $this->prepareSyncDataWithOrder($componentsOrder);

            // Sync Components
            // sync() akan handle attach/detach/update secara otomatis
            $section->components()->sync($syncData);
        }

        return $section;
    }

    /**
     * Delete a Section.
     * Relasi pivot akan otomatis terhapus karena onDelete('cascade') di migrasi.
     *
     * @param string $id UUID
     */
    public function deleteSection(string $id): bool
    {
        $section = $this->find($id);
        if ($section) {
            // Tidak perlu detach manual karena ada cascade delete di migrasi pivot
            return $section->delete();
        }

        return false;
    }

    /**
     * Helper to prepare data for sync with order.
     * Input: Array dari Controller (hasil decode JSON) -> [{id: 'uuid1', order: 0}, {id: 'uuid2', order: 1}]
     * Output: ['uuid1' => ['order' => 0], 'uuid2' => ['order' => 1]].
     */
    private function prepareSyncDataWithOrder(array $orderedItems): array
    {
        $syncData = [];
        // Pastikan input adalah array
        if (is_array($orderedItems)) {
            foreach ($orderedItems as $item) {
                // Validasi dasar item (mirip Component.php)
                if (is_array($item) && isset($item['id'], $item['order']) && is_string($item['id']) && is_int($item['order']) && $item['order'] >= 0) {
                    // Validasi UUID bisa ditambahkan di sini jika perlu, tapi sebaiknya di FormRequest
                    // if (preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/i', $item['id'])) {
                    $syncData[$item['id']] = ['order' => $item['order']];
                    // }
                }
                // Abaikan item yang tidak valid
            }
        }

        return $syncData;
    }
}
