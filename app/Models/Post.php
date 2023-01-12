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
    public function GetUserById($id = null)
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

    public function StoreCategory(Type $var = null)
    {
        # code...
    }

    public function StoreTag(Type $var = null)
    {
        # code...
    }

    public function StoreMeta(Type $var = null)
    {
        # code...
    }

    public function StoreCanonical(Type $var = null)
    {
        # code...
    }
}
