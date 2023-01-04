<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Models\Post;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, HasTranslations;

    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
    ];

    protected $translatable = [
        'name',
    ];

    protected $hidden = [
        'id'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string)Uuid::generate(4);
        });
    }

    // Relations to Post
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'category_post');
    }

    // Multilevel Categories
    public function subcategory()
    {
        return $this->hasMany(\App\Models\Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(\App\Models\Category::class, 'parent_id');
    }

    public function GetCategoryQuery()
    {
        return $this->query();
    }

    // CRUD
    public function StoreCategory($data = null)
    {
        if ($data['slug'] == null || $data['slug'] == '') {
            $data['slug'] = Str::slug($data['name']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        if ($data['parent'] == null || $data['parent'] == '') {
            $data['parent'] = '';
        } else {
            $data['parent'] = $data['parent'];
        }

        return $this->create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'parent_id' => $data['parent'],
        ]);
    }

    public function GetCategoryById($id)
    {
        return $this->query()->find($id);
    }

    public function UpdateCategory($new_categorydata, $id)
    {
        if ($new_categorydata['slug'] == null || $new_categorydata['slug'] == '') {
            $new_categorydata['slug'] = Str::slug($new_categorydata['name']);
        } else {
            $new_categorydata['slug'] = Str::slug($new_categorydata['slug']);
        }

        if ($new_categorydata['parent'] == null || $new_categorydata['parent'] == '') {
            $new_categorydata['parent_id'] = '';
        } else {
            $new_categorydata['parent_id'] = $new_categorydata['parent'];
        }
        $categorydata = $this->GetCategoryById($id);
        $categorydata->update($new_categorydata);
    }

    public function DeleteCategory($id)
    {
        return $this->query()->find($id)->forceDelete();
    }
}
