<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'token'
    ];

    public function StoreToken($user_id, $token)
    {
        return $this->create([
            'user_id' => $user_id,
            'token' => $token,
        ]);
    }

    public function GetUUIDByToken($token)
    {
        return $this->where('token', '=', $token)->first();
    }

    public function DeleteToken($id)
    {
        return $this->where('user_id', '=', $id)->delete();
    }



}
