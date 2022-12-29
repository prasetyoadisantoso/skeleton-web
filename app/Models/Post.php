<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Models\Category;
use Webpatser\Uuid\Uuid;
use App\Models\Tag;

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
    ];

    protected $translatable = [
        'title',
        'content',
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

    // Relations
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_post');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_post');
    }
}
