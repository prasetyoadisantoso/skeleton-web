<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Webpatser\Uuid\Uuid;

class Schemadata extends Model
{
    use HasFactory;
    use HasTranslations;

    public $incrementing = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'schema_name',
        'schema_type',
        'schema_content',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'schemadata_post');
    }
}
