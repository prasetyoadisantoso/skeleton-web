<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Storage;

class MediaLibrary extends Model
{
    use HasFactory, HasTranslations;

    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'information',
        'description',
        'media_files',
    ];

    protected $translatable = [];

    protected $hidden = ['id'];

    protected $casts = ['published_at' => 'datetime'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    public function GetMediaLibraryById($id = null)
    {
        return $this->query()->find($id);
    }

    public function StoreMediaLibrary($data = null)
    {

        $data = $this->create([
            'title' => $data['title'],
            'information' => $data['information'],
            'description' => $data['description'],
            'media_files' => $data['media-files'],
        ]);

        return $data;
    }

    public function UpdateMediaLibrary($data = null, $id) {

        $medialibrary = $this->GetMediaLibraryById($id);

        $medialibrary->title = $data['title'];
        $medialibrary->information = $data['information'];
        $medialibrary->description = $data['description'];

        $medialibrary->save();

        return $medialibrary;
    }

    public function DeleteMediaLibrary($id) {
        $delete_media = $this->GetMediaLibraryById($id);

        Storage::delete('/public' . '/' . $delete_media->media_files);

        return $this->find($delete_media->id)->forceDelete();
    }

}
