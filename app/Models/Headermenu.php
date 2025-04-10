<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Webpatser\Uuid\Uuid;

class Headermenu extends Model
{
    use HasFactory;
    use HasTranslations;

    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'label',
        'url',
        'icon',
        'parent_id',
        'order',
        'target',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $translatable = [
        'label',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    public function children()
    {
        return $this->hasMany(HeaderMenu::class, 'parent_id')->orderBy('order');
    }

    public function parent()
    {
        return $this->belongsTo(HeaderMenu::class, 'parent_id');
    }

    public function getHeaderMenuById($id)
    {
        return $this->query()->find($id);
    }

    public function StoreHeaderMenu($data = null)
    {
        if ($data['is_active'] == 'on') {
            $data['is_active'] = true;
        } else {
            $data['is_active'] = false;
        }

        return $this->create([
            'name' => $data['name'],
            'label' => $data['label'],
            'url' => $data['url'],
            'icon' => $data['icon'],
            'parent_id' => $data['parent_id'],
            'order' => $data['order'],
            'target' => $data['target'],
            'is_active' => $data['is_active'],
        ]);
    }

    public function UpdateHeaderMenu($new_HeaderMenu, $id)
    {
        $HeaderMenu = $this->GetHeaderMenuById($id);
        $HeaderMenu->update($new_HeaderMenu);

        return $HeaderMenu;
    }

    public function DeleteHeaderMenu($id)
    {
        return $this->query()->find($id)->delete();
    }
}
