<?php

namespace App\Models;

use App\Traits\ModelsTrait;
use App\Traits\PermissionTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, ModelsTrait, PermissionTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]    
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
     * The attributes that should be hidden for serialization.
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
     * The attributes that should be cast.
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
        return $this->belongsToMany(Permisologia\Role::class);
    }

    /**
     * Obtener los permisos que posee el usuario.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permisologia\Permission::class);
    }

    /**
     * Obtener el club que posee el usuario.
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    /**
     * Obtener la pareja que posee el usuario.
     */
    public function parejas()
    {
        return $this->hasMany(Pareja::class);
    }
}
