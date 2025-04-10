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

    // Relation to Metas
    public function metas()
    {
        return $this->belongsToMany(Meta::class, 'meta_category');
    }

    // Relation to Opengraph
    public function opengraphs()
    {
        return $this->belongsToMany(Opengraph::class, 'opengraph_category');
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

        $category = $this->create([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'parent_id' => $data['parent'],
        ]);

        if ($data['meta'] != null || $data['meta'] != '') {
            $category->metas()->attach($data['meta']);
        }

        if ($data['opengraph'] != null || $data['opengraph'] != '') {
            $category->opengraphs()->attach($data['opengraph']);
        }

        return $category;
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

        if ($new_categorydata['meta'] != null || $new_categorydata['meta'] != '') {
            $categorydata->metas()->sync($new_categorydata['meta']);
        }

        if ($new_categorydata['opengraph'] != null || $new_categorydata['opengraph'] != '') {
            $categorydata->opengraphs()->sync($new_categorydata['opengraph']);
        }

        $categorydata->update($new_categorydata);

        return $categorydata;
    }

    public function DeleteCategory($id)
    {
        $delete_category = $this->GetCategoryById($id);
        $delete_category->metas()->detach();
        $delete_category->opengraphs()->detach();
        return $this->find($delete_category->id)->forceDelete();
    }
}
