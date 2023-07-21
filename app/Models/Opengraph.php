<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Webpatser\Uuid\Uuid;

class Opengraph extends Model
{
    use HasFactory, HasTranslations;

    public $primaryKey = 'id';

    public $incrementing = false;

    public $translatable = [
        'description'
    ];

    public $fillable = [
        'name', 'title', 'description', 'url', 'site_name'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    public function GetOpengraphById($id)
    {
        return $this->query()->find($id);
    }

    public function StoreOpengraph($data = null)
    {
        return $this->create([
            'name' => $data['name'],
            'title' => $data['title'],
            'description' => $data['description'],
            'url' => $data['url'],
            'site_name' => $data['site_name'],
        ]);
    }

    public function UpdateOpengraph($new_opengraph, $id)
    {
        $opengraph = $this->GetOpengraphById($id);
        $opengraph->update($new_opengraph);
    }

    public function DeleteOpengraph($id)
    {
        return $this->query()->find($id)->forceDelete();
    }

}
