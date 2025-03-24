<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
// use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

// use Spatie\Activitylog\LogOptions;

class General extends Model
{
    use HasFactory;
    use HasTranslations
    // LogsActivity
    ;

    public $incrementing = false;

    public $translatable = [
        'site_tagline',
        'copyright',
        'cookies_concern',
    ];

    protected $primaryKey = 'id';

    protected $fillable = [
        'site_title',
        'site_tagline',
        'site_email',
        'url_address',
        'google_tag',
        'copyright',
        'cookies_concern',
        'site_logo_id',
        'site_favicon_id',
    ];

    public function UpdateSiteDescription($data)
    {
        $current_data = $this->query()->find($data['id']);

        return $current_data->update($data);
    }

    public function UpdateSiteLogoFavicon($data)
    {
        $current_data = $this->query()->find($data['id']);
        if (isset($data['site_logo'])) {
            // Delete image file
            Storage::delete('/public/'.$current_data->site_logo);
        }

        if (isset($data['site_favicon'])) {
            // Delete image file
            Storage::delete('/public/'.$current_data->site_favicon);
        }

        return $current_data->update($data);
    }

    // public function getActivitylogOptions(): LogOptions
    // {
    //     return LogOptions::defaults();
    // }

    // Relations to Medialibrary
    public function medialibraries()
    {
        return $this->belongsToMany(MediaLibrary::class, 'medialibrary_general');
    }

    // Define the relationship to MediaLibrary for site logo
    public function siteLogo()
    {
        return $this->belongsTo(MediaLibrary::class, 'site_logo_id');
    }

    // Define the relationship to MediaLibrary for site favicon
    public function siteFavicon()
    {
        return $this->belongsTo(MediaLibrary::class, 'site_favicon_id');
    }
}
