<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Canonical extends Model
{
    use HasFactory;

    public $primaryKey = 'id';

    public $incrementing = false;

    public $fillable = [
        'name',
        'url',
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
        return $this->belongsToMany(Post::class, 'canonical_post');
    }

    // CRUD Canonical
    public function GetCanonicalById($id)
    {
        return $this->query()->find($id);
    }

    public function StoreCanonical($data)
    {
        return $this->create([
            'name' => $data['name'],
            'url' => $data['url'],
        ]);
    }

    public function UpdateCanonical($new_canonical, $id)
    {
        $canonical = $this->GetCanonicalById($id);

        $canonical->update($new_canonical);

        return $canonical;
    }

    public function DeleteCanonical($id)
    {
        $canonical = $this->GetCanonicalById($id);
        $canonical->posts()->detach();

        return $canonical->forceDelete();
    }
}
