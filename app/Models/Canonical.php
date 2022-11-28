<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Webpatser\Uuid\Uuid;

class Canonical extends Model
{
    use HasFactory, LogsActivity;

    public $primaryKey = 'id';

    public $incrementing = false;

    public $fillable = [
        'name', 'url'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

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
        return $this->query()->find($id)->forceDelete();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
