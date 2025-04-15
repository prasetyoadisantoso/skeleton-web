<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Spatie\Translatable\HasTranslations;
use Webpatser\Uuid\Uuid; // <-- Tambahkan jika belum ada

class Component extends Model
{
    use HasFactory;
    use HasTranslations;

    public $incrementing = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
        'is_active', // Pastikan is_active ada di fillable
    ];

    protected $translatable = ['description'];

    protected $casts = [
        'is_active' => 'boolean', // Casting ke boolean
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Uuid::generate(4);
        });
    }

    // --- RELATIONS ---
    public function contentImages()
    {
        return $this->belongsToMany(ContentImage::class, 'component_content_image')
                    ->withPivot('order')
                    ->orderBy('pivot_order', 'asc');
    }

    public function contentTexts()
    {
        return $this->belongsToMany(ContentText::class, 'component_content_text')
                    ->withPivot('order')
                    ->orderBy('pivot_order', 'asc');
    }

    // --- CRUD Helper Methods ---

    public function getComponentById($id = null)
    {
        return $this->with(['contentImages', 'contentTexts'])->find($id);
    }

    public function getComponentsQuery()
    {
        return $this->query();
    }

    /**
     * Store a new Component and sync relations.
     *
     * @param array $data Validated data from FormRequest
     *
     * @return Component
     */
    public function storeComponent(array $data) // Type hint $data sebagai array
    {
        $imageOrderInput = Arr::get($data, 'content_images_order', []);
        $textOrderInput = Arr::get($data, 'content_texts_order', []);

        $imageSyncData = $this->prepareSyncDataWithOrder($imageOrderInput, 'image');
        $textSyncData = $this->prepareSyncDataWithOrder($textOrderInput, 'text'); // <

        $componentData = Arr::only($data, $this->getFillable());

        $component = $this->create($componentData);

        // Sync Images
        if (!empty($imageSyncData)) {
            $component->contentImages()->sync($imageSyncData);
        } else {
            $component->contentImages()->detach();
        }

        // Sync Texts <-- Tambahkan/Pastikan blok ini ada
        if (!empty($textSyncData)) {
            $component->contentTexts()->sync($textSyncData);
        } else {
            $component->contentTexts()->detach();
        }

        return $component;
    }

    /**
     * Update an existing Component and sync relations.
     *
     * @param array $data Validated data from FormRequest
     *
     * @return Component|null
     */
    public function updateComponent(string $id, array $data) // Type hint $data
    {
        $component = $this->find($id);
        if ($component) {

            // Ambil data relasi
            $imageOrderInput = Arr::get($data, 'content_images_order', []);
            $textOrderInput = Arr::get($data, 'content_texts_order', []);

            // Siapkan data sync
            $imageSyncData = $this->prepareSyncDataWithOrder($imageOrderInput);
            $textSyncData = $this->prepareSyncDataWithOrder($textOrderInput, 'text');

            // Update Component hanya dengan field fillable
            $componentData = Arr::only($data, $this->getFillable());
            $component->update($componentData);

            // Lakukan sync HANYA jika ada data sync
            if (!empty($imageSyncData)) {
                $component->contentImages()->sync($imageSyncData); // Ini akan detach yang tidak ada di $imageSyncData
            } else {
                // Jika $imageSyncData KOSONG (semua gambar dihapus dari list)
                $component->contentImages()->detach(); // Hapus semua relasi gambar yang ada
            }

            // Sync Texts <-- Tambahkan/Pastikan blok ini ada
            if (!empty($textSyncData)) {
                $component->contentTexts()->sync($textSyncData);
            } else {
                $component->contentTexts()->detach();
            }
        }

        return $component;
    }

    public function deleteComponent($id)
    {
        $component = $this->find($id);
        if ($component) {
            return $component->delete();
        }

        return false;
    }

    /*
     * Helper to prepare data for sync with order.
     * Input: Array dari FormRequest -> [{id: 'uuid1', order: 0}, {id: 'uuid2', order: 1}]
     * Output: ['uuid1' => ['order' => 0], 'uuid2' => ['order' => 1]]
     */
    private function prepareSyncDataWithOrder(array $orderedItems): array
    {
        $syncData = [];
        // Pastikan input adalah array
        if (is_array($orderedItems)) {
            foreach ($orderedItems as $item) {
                // Pastikan item adalah array dan memiliki 'id' serta 'order' yang valid
                if (is_array($item) && isset($item['id']) && isset($item['order']) && is_string($item['id']) && is_int($item['order']) && $item['order'] >= 0) {
                    $syncData[$item['id']] = ['order' => $item['order']];
                }
                // Abaikan item yang tidak valid
            }
        }

        return $syncData;
    }
}
