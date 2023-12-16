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
        'name', 'url'
    ];

    protected $locked_id = [
        // Home
        '37039e16-12bf-435f-938f-24c6b167d16b',

        // Blog
        '252a4bee-48f4-4977-8806-52db10cdbc7f',

        // Contact
        '082c03cb-517f-482e-93ba-f9918d7b033c'
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

        if (in_array($canonical->id, $this->locked_id)) {
            throw new \Exception("Cannot update or delete a locked record.");
        } else {
            $canonical->update($new_canonical);
            return $canonical;
        }
    }

    public function DeleteCanonical($id)
    {
        $canonical = $this->GetCanonicalById($id);
        if (in_array($canonical->id, $this->locked_id)) {
            return false;
        } else {
            $canonical->tags()->detach();
            $canonical->posts()->detach();
            $canonical->categories()->detach();
            return $canonical->forceDelete();
        }
    }
}
