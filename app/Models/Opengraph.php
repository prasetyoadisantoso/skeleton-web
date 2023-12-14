<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;
use Webpatser\Uuid\Uuid;

class Opengraph extends Model
{
    use HasFactory, HasTranslations;

    public $primaryKey = 'id';

    public $incrementing = false;

    public $translatable = [
        'description',
    ];

    public $fillable = [
        'name', 'title', 'description', 'url', 'site_name', 'image', 'type',
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
        return $this->belongsToMany(Post::class, 'opengraph_post');
    }

    // Relations to Category
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'opengraph_category');
    }

    // Relations to Tag
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'opengraph_tag');
    }

    public function GetOpengraphById($id)
    {
        return $this->query()->find($id);
    }

    public function StoreOpengraph($data = null)
    {
        if (!isset($data['image'])) {
            $data['image'] = null;
        }

        return $this->create([
            'name' => $data['name'],
            'title' => $data['title'],
            'description' => $data['description'],
            'url' => $data['url'],
            'site_name' => $data['site_name'],
            'image' => $data['image'],
            'type' => $data['type'],
        ]);
    }

    public function UpdateOpengraph($new_opengraph, $id)
    {
        $opengraph = $this->GetOpengraphById($id);

        if (isset($new_opengraph['image'])) {
            // Delete image file
            Storage::delete('/public' . '/' . $opengraph->image);
        }

        $opengraph->update($new_opengraph);
    }

    public function DeleteOpengraph($id)
    {
        $opengraph = $this->GetOpengraphById($id);
        Storage::delete('/public' . '/' . $opengraph->image);
        return $this->query()->find($id)->forceDelete();
    }

}
