<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;
use Webpatser\Uuid\Uuid;
use App\Models\Meta;
use App\Models\Opengraph;

class Tag extends Model
{
    use HasFactory, HasTranslations;

    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $translatable = [
        'name',
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

    // Relations to Post
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'tag_post');
    }

    // Relation to Metas
    public function metas()
    {
        return $this->belongsToMany(Meta::class, 'meta_tag');
    }

    // Relation to Opengraph
    public function opengraphs()
    {
        return $this->belongsToMany(Opengraph::class, 'opengraph_tag');
    }

    // CRUD
    public function StoreTag($data = null)
    {
        if ($data['slug'] == null || $data['slug'] == '') {
            $data['slug'] = Str::slug($data['name']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        $tag = $this->create([
            'name' => $data['name'],
            'slug' => $data['slug'],
        ]);

        if ($data['meta'] != null || $data['meta'] != '') {
            $tag->metas()->attach($data['meta']);
        }

        if ($data['opengraph'] != null || $data['opengraph'] != '') {
            $tag->opengraphs()->attach($data['opengraph']);
        }

        return $tag;
    }

    public function GetTagById($id)
    {
        return $this->query()->find($id);
    }

    public function UpdateTag($new_tagdata, $id)
    {
        if ($new_tagdata['slug'] == null || $new_tagdata['slug'] == '') {
            $new_tagdata['slug'] = Str::slug($new_tagdata['name']);
        } else {
            $new_tagdata['slug'] = Str::slug($new_tagdata['slug']);
        }
        $tagdata = $this->GetTagById($id);

        if ($new_tagdata['meta'] != null || $new_tagdata['meta'] != '') {
            $tagdata->metas()->sync($new_tagdata['meta']);
        }

        if ($new_tagdata['opengraph'] != null || $new_tagdata['opengraph'] != '') {
            $tagdata->opengraphs()->sync($new_tagdata['opengraph']);
        }

        $tagdata->update($new_tagdata);

        return $tagdata;
    }

    public function DeleteTag($id)
    {
        $delete_tag = $this->GetTagById($id);
        $delete_tag->metas()->detach();
        $delete_tag->opengraphs()->detach();
        return $this->find($delete_tag->id)->forceDelete();
    }

}
