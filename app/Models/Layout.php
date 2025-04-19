<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;
use App\Models\Section;

class Layout extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'type', // 'full-width' atau 'sidebar'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Uuid::generate(4);
        });
    }

    // In app/Models/Layout.php
    public function sections()
    {
        return $this->belongsToMany(Section::class, 'layout_section')
                    ->withPivot('order', 'location') // <-- PASTIKAN 'location' ADA DI SINI
                    ->withTimestamps();
    }

    // Relasi spesifik sectionsMain (PERBAIKI SINTAKS)
    public function sectionsMain()
    {
        // Gunakan relasi utama dan tambahkan filter pivot
        return $this->belongsToMany(Section::class, 'layout_section') // <-- LENGKAPI ARGUMEN
                    ->wherePivot('location', 'main')
                    ->withPivot('location', 'order') // withPivot bisa diulang atau cukup di sections()
                    ->orderBy('layout_section.order'); // <-- LENGKAPI ARGUMEN
    }

    // Relasi spesifik sectionsSidebar (PERBAIKI SINTAKS)
    public function sectionsSidebar()
    {
        // Gunakan relasi utama dan tambahkan filter pivot
        return $this->belongsToMany(Section::class, 'layout_section') // <-- LENGKAPI ARGUMEN
                    ->wherePivot('location', 'sidebar')
                    ->withPivot('location', 'order') // withPivot bisa diulang atau cukup di sections()
                    ->orderBy('layout_section.order'); // <-- LENGKAPI ARGUMEN
    }

    // Getter untuk urutan section di main (Untuk mempermudah akses order)
    public function getMainSectionOrderAttribute()
    {
        $sections = $this->sectionsMain;
        $order = [];
        foreach ($sections as $section) {
            $order[] = [
                'id' => $section->id,
                'order' => $section->pivot->order,
            ];
        }

        return $order;
    }

    // Getter untuk urutan section di sidebar (Untuk mempermudah akses order)
    public function getSidebarSectionOrderAttribute()
    {
        $sections = $this->sectionsSidebar;
        $order = [];
        foreach ($sections as $section) {
            $order[] = [
                'id' => $section->id,
                'order' => $section->pivot->order,
            ];
        }

        return $order;
    }
}
