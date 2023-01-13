<?php

namespace App\Models;

use App\Models\Canonical;
use App\Models\Category;
use App\Models\Meta;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory, HasTranslations;

    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'feature_image',
        'slug',
        'content',
        'published_at'
    ];

    protected $translatable = [
        'title',
        'content',
    ];

    protected $hidden = [
        'id',
    ];

    protected $dates = ['published_at'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    // Relations to Categories
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_post');
    }

    // Relation to Metas
    public function metas()
    {
        return $this->belongsToMany(Meta::class, 'meta_post');
    }

    // Relation to Canonicals
    public function canonicals()
    {
        return $this->belongsToMany(Canonical::class, 'canonical_post');
    }

    // Relation to Tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_post');
    }

    // CRUD Post\
    public function GetPostById($id = null)
    {
        return $this->query()->find($id);
    }

    public function StorePost($data = null)
    {
        if (array_key_exists('published', $data)) {
            if ($data['published'] == "on") {
                $data['published'] = date('Y-m-d H:i:s');;
            } else {
                $data['published'] = null;
            }
        } else {
            $data['published'] = null;
        }

        if (!isset($data['feature_image'])) {
            $data['feature_image'] = null;
        }

        if ($data['slug'] == null || $data['slug'] == '') {
            $data['slug'] = Str::slug($data['title']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        $post = $this->create([
            'title' => $data['title'],
            'feature_image' => $data['feature_image'],
            'slug' => $data['slug'],
            'content' => $data['content'],
            'published_at' => $data['published']
        ]);

        if ($data['category'] != null || $data['category'] != '') {
            $post->categories()->attach($data['category']);
        }

        if (array_key_exists('tag', $data)) {
            $post->tags()->attach($data['tag']);
        }

        if ($data['meta'] != null || $data['meta'] != '') {
            $post->metas()->attach($data['meta']);
        }

        if ($data['canonical'] != null || $data['canonical'] != '') {
            $post->canonicals()->attach($data['canonical']);
        }

        return $post;
    }

    public function UpdatePost($data = null, $id = null)
    {
        if (array_key_exists('published', $data)) {
            if ($data['published'] == "on") {
                $data['published_at'] = date('Y-m-d H:i:s');
            } else {
                $data['published_at'] = null;
            }
        } else {
            $data['published_at'] = null;
        }

        if ($data['slug'] == null || $data['slug'] == '') {
            $data['slug'] = Str::slug($data['title']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        $current_post = $this->GetPostById($id);

        if (isset($feature['feature_image'])) {
            // Delete image file
            Storage::delete('/public' . '/' . $current_post->feature_image);
        }

        if ($data['category'] != null || $data['category'] != '') {
            $current_post->categories()->sync($data['category']);
        }

        if (array_key_exists('tag', $data)) {
            $current_post->tags()->sync($data['tag']);
        } else {
            $current_post->tags()->detach();
        }

        if ($data['meta'] != null || $data['meta'] != '') {
            $current_post->metas()->sync($data['meta']);
        }

        if ($data['canonical'] != null || $data['canonical'] != '') {
            $current_post->canonicals()->sync($data['canonical']);
        }

        $current_post->update($data);

        return $current_post;
    }

    public function DeletePost($id)
    {
        $delete_post = $this->GetPostByID($id);
        $delete_post->tags()->detach();
        $delete_post->categories()->detach();
        $delete_post->metas()->detach();
        $delete_post->canonicals()->detach();

        // Delete image file
        Storage::delete('/public' . '/' . $delete_post->image);

        return $this->find($delete_post->id)->forceDelete();
    }


}
