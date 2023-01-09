<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Webpatser\Uuid\Uuid;

class Meta extends Model
{
    use HasFactory, HasTranslations;

    public $primaryKey = 'id';

    public $incrementing = false;

    public $translatable = [
      'description', 'keyword'
    ];

    public $fillable = [
        'name', 'robot', 'description', 'keyword'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    // Relations to Post
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'meta_post');
    }

    // CRUD Meta
    public function GetMetaById($id)
    {
        return $this->query()->find($id);
    }

    public function StoreMeta($data = null)
    {
        return $this->create([
            'name' => $data['name'],
            'robot' => $data['robot'],
            'description' => $data['description'],
            'keyword' => $data['keyword'],
        ]);
    }

    public function UpdateMeta($new_metadata, $id)
    {
        $metadata = $this->GetMetaById($id);
        $metadata->update($new_metadata);
    }

    public function DeleteMeta($id)
    {
        return $this->query()->find($id)->forceDelete();
    }

}
