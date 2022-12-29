<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Models\Post;
use Webpatser\Uuid\Uuid;

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
}
