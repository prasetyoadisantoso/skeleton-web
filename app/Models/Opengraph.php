<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;
use Webpatser\Uuid\Uuid;

class Opengraph extends Model
{
    use HasFactory;
    use HasTranslations;

    public $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = [
        'og_title',
        'og_description',
        'og_type',
        'og_url',
        'og_image_id',
    ];

    public $translatable = [
        'og_title',
        'og_description',
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

    public function mediaLibraries()
    {
        return $this->belongsTo(MediaLibrary::class, 'og_image_id');
    }

    public function GetOpengraphById($id)
    {
        return $this->query()->find($id);
    }

    public function StoreOpengraph($data = null)
    {
        return $this->create([
            'og_title' => $data['og_title'],
            'og_description' => $data['og_description'],
            'og_type' => $data['og_type'],
            'og_url' => $data['og_url'],
            'og_image_id' => $data['og_image_id'],
        ]);
    }

    public function UpdateOpengraph($new_opengraph, $id)
    {
        $opengraph = $this->GetOpengraphById($id);

        if (in_array($opengraph->id, $this->locked_id)) {
            throw new \Exception('Cannot update or delete a locked record.');
        } else {
            if (isset($new_opengraph['image'])) {
                // Delete image file
                Storage::delete('/public/'.$opengraph->image);
            }

            $opengraph->update($new_opengraph);
        }
    }

    public function DeleteOpengraph($id)
    {
        $opengraph = $this->GetOpengraphById($id);

        $opengraph->tags()->detach();
        $opengraph->posts()->detach();
        $opengraph->categories()->detach();

        return $opengraph->forceDelete();
    }
}
