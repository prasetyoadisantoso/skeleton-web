<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Webpatser\Uuid\Uuid; // Pastikan use Uuid

class ContentText extends Model
{
    use HasFactory;
    use HasTranslations;

    public $incrementing = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'type',
        'content',
    ];

    protected $translatable = ['content'];

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
     * The Components that this ContentImage belongs to.
     */
    public function components()
    {
        // Definisikan relasi ke Component melalui pivot table
        return $this->belongsToMany(Component::class, 'component_content_text')
                    ->withPivot('order'); // Sertakan order jika perlu diakses dari sisi ContentImage
    }

    // --- Optional CRUD Helper Methods ---

    /**
     * Get ContentText by ID.
     *
     * @param string|null $id
     *
     * @return ContentText|null
     */
    public function getContentTextById($id = null)
    {
        return $this->find($id);
    }

    /**
     * Get ContentText query builder.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getContentTextsQuery()
    {
        return $this->query();
    }

    /**
     * Store a new ContentText.
     *
     * @param array|null $data
     *
     * @return ContentText
     */
    public function storeContentText($data = null)
    {
        return $this->create($data);
    }

    /**
     * Update an existing ContentText.
     *
     * @param string     $id
     * @param array|null $data
     *
     * @return ContentText|null
     */
    public function updateContentText($id, $data = null)
    {
        $contentText = $this->find($id);
        if ($contentText) {
            $contentText->update($data);
        }

        return $contentText;
    }

    /**
     * Delete a ContentText.
     *
     * @param string $id
     *
     * @return bool
     */
    public function deleteContentText($id)
    {
        $contentText = $this->find($id);
        if ($contentText) {
            return $contentText->delete();
        }

        return false;
    }

}
