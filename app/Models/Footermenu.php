<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Webpatser\Uuid\Uuid;

class Footermenu extends Model
{
    use HasFactory;
    use HasTranslations;

    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',     // Nama internal
        'label',    // Teks yang ditampilkan
        'url',      // URL tujuan
        'icon',     // Class ikon (opsional)
        'order',    // Urutan
        'target',   // Target link (_self, _blank)
        'is_active', // Status aktif/tidak
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Kolom yang bisa diterjemahkan
    protected $translatable = [
        'label',
    ];

    // Otomatis generate UUID saat membuat record baru
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    // --- CRUD Methods ---

    /**
     * Mengambil data Footermenu berdasarkan ID.
     *
     * @param string $id
     *
     * @return Footermenu|null
     */
    public function getFooterMenuById($id)
    {
        return $this->query()->find($id);
    }

    /**
     * Menyimpan data Footermenu baru.
     *
     * @param array|null $data
     *
     * @return Footermenu
     */
    public function StoreFooterMenu($data = null)
    {
        // Konversi status 'on'/'off' dari checkbox ke boolean
        $data['is_active'] = isset($data['is_active']) && $data['is_active'] == 'on';

        return $this->create([
            'name' => $data['name'],
            'label' => $data['label'],
            'url' => $data['url'] ?? null, // Pastikan URL bisa null
            'icon' => $data['icon'] ?? null, // Pastikan icon bisa null
            'order' => $data['order'] ?? 0, // Default order jika tidak ada
            'target' => $data['target'] ?? '_self', // Default target jika tidak ada
            'is_active' => $data['is_active'],
        ]);
    }

    /**
     * Memperbarui data Footermenu yang ada.
     *
     * @param array  $newData
     * @param string $id
     *
     * @return Footermenu|null
     */
    public function UpdateFooterMenu($newData, $id)
    {
        $footerMenu = $this->getFooterMenuById($id);
        if ($footerMenu) {
            // Konversi status 'on'/'off' jika ada dalam data baru
            if (isset($newData['is_active'])) {
                $newData['is_active'] = $newData['is_active'] == 'on';
            } else {
                // Jika checkbox tidak dicentang, form tidak mengirimkan nilainya,
                // jadi kita set manual ke false
                $newData['is_active'] = false;
            }
            $footerMenu->update($newData);
        }

        return $footerMenu;
    }

    /**
     * Menghapus data Footermenu berdasarkan ID.
     *
     * @param string $id
     *
     * @return bool|null
     */
    public function DeleteFooterMenu($id)
    {
        $footerMenu = $this->getFooterMenuById($id);
        if ($footerMenu) {
            return $footerMenu->delete();
        }

        return false;
    }

    /**
     * Mengambil query builder untuk Footermenu.
     * Berguna untuk DataTables atau query lanjutan.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getFooterMenusQuery()
    {
        return $this->query();
    }
}
