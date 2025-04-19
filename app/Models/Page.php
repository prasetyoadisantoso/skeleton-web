<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Webpatser\Uuid\Uuid;

class Page extends Model
{
    use HasFactory;
    use HasTranslations;

    public $incrementing = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'layout_id',
        'meta_id',
        'opengraph_id',
        'canonical_id',
        'schemadata_id',
    ];

    protected $translatable = ['title', 'content'];

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    // Relations
    public function layout()
    {
        return $this->belongsTo(Layout::class, 'layout_id');
    }

    public function meta()
    {
        return $this->belongsTo(Meta::class, 'meta_id');
    }

    public function opengraph()
    {
        return $this->belongsTo(Opengraph::class, 'opengraph_id');
    }

    public function canonical()
    {
        return $this->belongsTo(Canonical::class, 'canonical_id');
    }

    public function schemadata()
    {
        return $this->belongsTo(Schemadata::class, 'schemadata_id');
    }

    // Method Helper CRUD
    public function GetPageById($id = null)
    {
        return $this->query()->find($id);
    }

    public function StorePage($data = null)
    {
        return $this->create([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'content' => $data['content'],
            'layout_id' => $data['layout_id'],
            'meta_id' => $data['meta_id'],
            'opengraph_id' => $data['opengraph_id'],
            'canonical_id' => $data['canonical_id'],
            'schemadata_id' => $data['schemadata_id'],
        ]);
    }

    public function UpdatePage($newPage, $id)
    {
        $page = $this->GetPageById($id);
        $page->update($newPage);

        return $page;
    }

    public function DeletePage($id)
    {
        return $this->query()->find($id)->forceDelete();
    }

    public function getPageQuery()
    {
        return $this->query();
    }
}
