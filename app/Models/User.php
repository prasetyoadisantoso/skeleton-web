<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Webpatser\Uuid\Uuid;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use Notifiable;
    use HasRoles;

    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'image',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    // Get Author
    public function author()
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    public function GetAllUser()
    {
        return $this->all();
    }

    public function GetUserByID($id)
    {
        return $this->where('id', '=', $id)->first();
    }

    public function GetUserByEmail($email)
    {
        return $this->where('email', '=', $email)->first();
    }

    public function isUserVerified($email = null)
    {
        return $this->where('email', '=', $email)->get('email_verified_at');
    }

    public function StoreUser($data = null, $role = null)
    {

        if (!isset($data['phone'])) {
            $data['phone'] = null;
        }

        if (isset($data['status']) && $data['status'] == 'on') {
            $data['status'] = date('Y-m-d H:i:s');
        } else {
            $data['status'] = null;
        }

        $user = $this->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'email_verified_at' => $data['status'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole($role);
        $user->save();

        return $user;
    }

    public function UpdateUser($new_user_data, $id, $role)
    {
        if (!empty($new_user_data['password'])) {
            $new_user_data['password'] = Hash::make($new_user_data['password']);
        } else {
            $new_user_data = Arr::except($new_user_data, ['password']);
        }

        if (isset($new_user_data['status']) && $new_user_data['status'] == 'on') {
            $new_user_data['email_verified_at'] = date('Y-m-d H:i:s');
        } else {
            $new_user_data['email_verified_at'] = null;
        }

        $current_user_data = $this->GetUserByID($id);


        $current_user_data->removeRole($current_user_data->getRoleNames()[0]);
        $current_user_data->update($new_user_data);
        $current_user_data->assignRole($role);
    }

    public function DeleteUser($id)
    {
        $delete_user = $this->GetUserByID($id);

        // Delete image file
        Storage::delete('/public/'.$delete_user->image);

        return $this->find($delete_user->id)->forceDelete();
    }

    public function getUsersQueries()
    {
        return $this->query()->with('medialibraries', 'roles');
    }

    // Relations to Medialibrary
    public function medialibraries()
    {
        return $this->belongsToMany(MediaLibrary::class, 'medialibrary_user');
    }
}
