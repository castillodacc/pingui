<?php

namespace App;

use App\Traits\ModelsTrait;
use App\Traits\PermissionTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, ModelsTrait, PermissionTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'num_id',
        'email',
        'password',
        'phone',
        'user',
        'web',
        'confirm',
        'international_id',
        'sex',
        'birthdate',
        'febd_num',
        'category_l',
        'trainer_l',
        'category_s',
        'trainer_s',
        'group_l',
        'group_s',
        'club_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }

    /**
     * Obtener los roles que posee el usuario.
     */
    public function roles()
    {
        // pertenece a muchas
        return $this->belongsToMany(Models\Permisologia\Role::class);
    }

    /**
     * Obtener los permisos que posee el usuario.
     */
    public function permissions()
    {
        return $this->belongsToMany(Models\Permisologia\Permission::class);
    }

    public function club()
    {
        return $this->belongsTo(Models\Club::class);
    }

    public function parejas()
    {
        return $this->hasMany(Models\Pareja::class);
    }
}
