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
      'description'
    ];

    public $fillable = [
        'name', 'robot', 'description'
    ];

    protected $locked_id = [
        // Home
        '3ba81b32-6faa-4d56-8f7b-deb3ee778202',

        // Block
        'a98dbeb0-0acd-4571-93ef-121983fddf6a',

        // Blog Search
        'e5ef928b-b0ce-4b2d-9ab3-952744019547',

        // Blog Category
        'f2532093-edd0-4683-81d6-aa68edfdea5b',

        // Blog Tag
        '6777397c-b7bd-4ed3-9952-4200818df477',

        // Contact
        '131e6888-e3a8-46cb-b4aa-5a5bc8c892c6'
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
            'name' => $data['name'],
            'robot' => $data['robot'],
            'description' => $data['description'],
        ]);
    }

    public function UpdateMeta($new_metadata, $id)
    {
        $metadata = $this->GetMetaById($id);
        if ($metadata->id === 'e5ef928b-b0ce-4b2d-9ab3-952744019547') {
            throw new \Exception("Cannot update or delete a locked record.");
        } else {
            $metadata->update($new_metadata);
        }
    }

    public function DeleteMeta($id)
    {
        $data = $this->GetMetaById($id);
        if (in_array($data->id, $this->locked_id)) {
            return false;
        } else {
            $data->tags()->detach();
            $data->posts()->detach();
            $data->categories()->detach();
            return $data->forceDelete();
        }
    }

}
