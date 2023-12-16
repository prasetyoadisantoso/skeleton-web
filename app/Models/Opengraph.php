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

    protected $locked_id = [
        // Home
        '3e8edd87f-3b67-4191-98ba-c0455f9c7705',

        // Blog
        '53708182-01c8-4b0d-b39d-0494873b2e99',

        // Blog Search
        '309e0945-87e8-4b04-8154-e1d3f1409949',

        // Blog Category
        'e84b1cdf-3277-4739-9f7d-1dc489a3aaf7',

        // Blog Tag
        'bb73bcd6-18ad-42ec-9417-89c0f1bf08c0',

        // Contact
        '5a765094-a557-4f46-afa0-09ef37ca0b47'
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

        if (in_array($opengraph->id, $this->locked_id)) {
            throw new \Exception("Cannot update or delete a locked record.");
        } else {

            if (isset($new_opengraph['image'])) {
                // Delete image file
                Storage::delete('/public' . '/' . $opengraph->image);
            }

            $opengraph->update($new_opengraph);
        }
    }

    public function DeleteOpengraph($id)
    {
        $opengraph = $this->GetOpengraphById($id);


        if (in_array($opengraph->id, $this->locked_id)) {
            return false;
        } else {
            Storage::delete('/public' . '/' . $opengraph->image);
            $opengraph->tags()->detach();
            $opengraph->posts()->detach();
            $opengraph->categories()->detach();
            return $opengraph->forceDelete();
        }
    }

}
