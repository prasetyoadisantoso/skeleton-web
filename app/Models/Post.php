<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;
use Webpatser\Uuid\Uuid;

class Post extends Model
{
    use HasFactory;
    use HasTranslations;

    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'published_at',
        'author_id',
    ];

    protected $translatable = [
        'title',
        'content',
    ];

    protected $hidden = [
        'id',
    ];

    protected $casts = ['published_at' => 'datetime'];

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

    // Relation to Opengraph
    public function opengraphs()
    {
        return $this->belongsToMany(Opengraph::class, 'opengraph_post');
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

    // Get Author
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Relation to Schemas
    public function schemadatas()
    {
        return $this->belongsToMany(Schemadata::class,  'schemadata_post');
    }

    // Relation to MediaLibrary
    public function mediaLibraries()
    {
        return $this->belongsToMany(MediaLibrary::class, 'medialibrary_post');
    }

    // CRUD Post\
    public function GetPostById($id = null)
    {
        return $this->query()->find($id);
    }

    public function getPostsQueries()
    {
        return $this->query()->with('medialibraries');
    }

    public function StorePost($data = null)
    {
        if (array_key_exists('published', $data)) {
            if ($data['published'] == 'on') {
                $data['published'] = date('Y-m-d H:i:s');
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
            'published_at' => $data['published'],
            'author_id' => $data['author_id'],
        ]);

        // Attach MediaLibrary
        if (isset($data['media_library']) && is_array($data['media_library'])) {
            $post->mediaLibraries()->attach($data['media_library']);
        }

        if ($data['category'] != null || $data['category'] != '') {
            $post->categories()->attach($data['category']);
        }

        if (array_key_exists('tag', $data)) {
            $post->tags()->attach($data['tag']);
        }

        if ($data['meta'] != null || $data['meta'] != '') {
            $post->metas()->attach($data['meta']);
        }

        if ($data['opengraph'] != null || $data['opengraph'] != '') {
            $post->opengraphs()->attach($data['opengraph']);
        }

        if ($data['canonical'] != null || $data['canonical'] != '') {
            $post->canonicals()->attach($data['canonical']);
        }

        // Attach Schema
        if (isset($data['schema']) && $data['schema'] != '') {
            $post->schemadatas()->attach($data['schema']);
        }

        return $post;
    }

    public function UpdatePost($data = null, $id = null)
    {
        if (array_key_exists('published', $data)) {
            if ($data['published'] == 'on') {
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
            Storage::delete('/public/'.$current_post->feature_image);
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

        if ($data['opengraph'] != null || $data['opengraph'] != '') {
            $current_post->opengraphs()->sync($data['opengraph']);
        }

        if ($data['canonical'] != null || $data['canonical'] != '') {
            $current_post->canonicals()->sync($data['canonical']);
        }

        // Sync Schema
        if (isset($data['schema']) && is_array($data['schema'])) {
            $current_post->schemadatas()->sync($data['schema']);
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
        $delete_post->opengraphs()->detach();

        // Delete image file
        Storage::delete('/public/'.$delete_post->image);

        return $this->find($delete_post->id)->forceDelete();
    }
}
