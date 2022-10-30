<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Webpatser\Uuid\Uuid;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use Notifiable;
    use LogsActivity;
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
        if (isset($data['image']) == false || isset($data['phone']) == false) {
            $data['image'] = null;
            $data['phone'] = null;
        }

        $user = $this->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'image' => $data['image'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole($role);
        $user->save();

        return $user;

    }

    public function UpdateUser($new_user_data, $id)
    {
        if (!empty($new_user_data['password'])) {
            $new_user_data['password'] = Hash::make($new_user_data['password']);
        } else {
            $new_user_data = Arr::except($new_user_data, ['password']);
        }

        $current_user_data = $this->GetUserByID($id);

        if (isset($new_user_data['image'])) {
            // Delete image file
            Storage::delete('/public' . '/' . $current_user_data->image);
        }

        $current_user_data->update($new_user_data);
    }

    public function DeleteUser($id)
    {
        $delete_user = $this->GetUserByID($id);

        // Delete image file
        Storage::delete('/public' . '/' . $delete_user->image);

        $this->where('id', '=', $delete_user->id)->delete();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function getUsersQueries()
    {
        return $this->query();
    }

}
