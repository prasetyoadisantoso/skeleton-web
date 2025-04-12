<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Webpatser\Uuid\Uuid;

class ContentImage extends Model
{
    use HasFactory;
    use HasTranslations;

    public $incrementing = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'media_library_id',
        'alt_text',
        'caption',
    ];

    protected $translatable = ['alt_text', 'caption'];

    protected $hidden = [
        // 'id', // Mungkin ingin menyembunyikan ID jika tidak perlu di frontend
    ];

    /**
     * Boot function from Laravel.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Uuid::generate(4);
        });
    }

    /**
     * Relationship to MediaLibrary.
     */
    public function mediaLibrary()
    {
        return $this->belongsTo(MediaLibrary::class, 'media_library_id');
    }

    // --- Optional CRUD Helper Methods ---

    /**
     * Get ContentImage by ID.
     *
     * @param string|null $id
     *
     * @return ContentImage|null
     */
    public function getContentImageById($id = null)
    {
        return $this->with('mediaLibrary')->find($id);
    }

    /**
     * Get ContentImage query builder.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getContentImagesQuery()
    {
        return $this->query()->with('mediaLibrary');
    }

    /**
     * Store a new ContentImage.
     *
     * @param array|null $data
     *
     * @return ContentImage
     */
    public function storeContentImage($data = null)
    {
        return $this->create([
            'name' => $data['name'],
            'media_library_id' => $data['media_library_id'],
            'alt_text' => $data['alt_text'] ?? null,
            'caption' => $data['caption'] ?? null,
        ]);
    }

    /**
     * Update an existing ContentImage.
     *
     * @param string     $id
     * @param array|null $data
     *
     * @return ContentImage|null
     */
    public function updateContentImage($id, $data = null)
    {
        $contentImage = $this->find($id);
        if ($contentImage) {
            $contentImage->update([
                'name' => $data['name'],
                'media_library_id' => $data['media_library_id'] ?? $contentImage->media_library_id, // Update jika ada ID baru
                'alt_text' => $data['alt_text'] ?? $contentImage->alt_text,
                'caption' => $data['caption'] ?? $contentImage->caption,
            ]);
        }

        return $contentImage;
    }

    /**
     * Delete a ContentImage.
     * Note: The related MediaLibrary deletion is handled by the database cascade constraint.
     *
     * @param string $id
     *
     * @return bool
     */
    public function deleteContentImage($id)
    {
        $contentImage = $this->find($id);
        if ($contentImage) {
            return $contentImage->delete(); // Deletes ContentImage, cascade deletes MediaLibrary
        }

        return false;
    }
}
