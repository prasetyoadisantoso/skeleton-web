<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Webpatser\Uuid\Uuid;

class SocialMedia extends Model
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

    public function GetSocialMediaById($id)
    {
        return $this->query()->find($id);
    }

    public function StoreSocialMedia($data)
    {
        return $this->create([
            'name' => $data['name'],
            'url' => $data['url'],
        ]);
    }

    public function UpdateSocialMedia($social_media, $id)
    {
        $socialmedia = $this->GetSocialMediaById($id);
        $socialmedia->update($social_media);
        return $socialmedia;
    }

    public function DeleteSocialMedia($id)
    {
        return $this->query()->find($id)->forceDelete();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
