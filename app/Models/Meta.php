<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;
use Webpatser\Uuid\Uuid;

class Meta extends Model
{
    use HasFactory;
    use HasTranslations;

    public $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = [
        'title',
        'description',
        'keywords',
    ];

    public $translatable = [
        'title',
        'description',
        'keywords',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    // Relations to Post
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'meta_post', 'meta_id', 'post_id');
    }

    // Relations to Category
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'meta_category');
    }

    // Relations to Tag
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'meta_tag');
    }

    // CRUD Meta
    public function GetMetaById($id)
    {
        return $this->query()->find($id);
    }

    public function StoreMeta($data = null)
    {
        return $this->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'keywords' => $data['keyword'],
        ]);
    }

    public function UpdateMeta($new_metadata, $id)
    {
        $metadata = $this->GetMetaById($id);
        $metadata->update($new_metadata);
    }

    public function DeleteMeta($id)
    {
        $data = $this->GetMetaById($id);

        $data->tags()->detach();
        $data->posts()->detach();
        $data->categories()->detach();

        return $data->forceDelete();
    }
}
