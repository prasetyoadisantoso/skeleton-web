<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;
use Webpatser\Uuid\Uuid;

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

    // CRUD
    public function StoreTag($data = null)
    {
        if ($data['slug'] == null || $data['slug'] == '') {
            $data['slug'] = Str::slug($data['name']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        return $this->create([
            'name' => $data['name'],
            'slug' => $data['slug'],
        ]);
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
        $tagdata->update($new_tagdata);
    }

    public function DeleteTag($id)
    {
        return $this->query()->find($id)->forceDelete();
    }

}
