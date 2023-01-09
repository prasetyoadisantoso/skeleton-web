<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Models\Category;
use Webpatser\Uuid\Uuid;
use App\Models\Tag;
use App\Models\Canonical;
use App\Models\Meta;

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
}
