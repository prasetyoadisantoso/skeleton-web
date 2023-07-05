<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Message extends Model
{
    use HasFactory;

    public $primaryKey = 'id';

    public $incrementing = false;

    public $fillable = [
        'name', 'email', 'phone', 'message', 'read_at'
    ];

    protected $dates = ['read_at'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    // CRUD Message
    public function GetMessageById($id)
    {
        return $this->query()->find($id);
    }

    public function StoreMessage($data = null)
    {
        return $this->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'message' => $data['message'],
        ]);
    }

    public function UpdateMessage($new_message, $id)
    {
        $message = $this->GetMessageById($id);
        $message->update($new_message);
    }

    public function DeleteMessage($id)
    {
        return $this->query()->find($id)->forceDelete();
    }

}
