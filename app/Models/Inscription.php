<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelsTrait;

class Inscription extends Model
{
	use SoftDeletes, ModelsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'tournament_id',
        'febd_num_1',
        'name_1',
        'last_name_1',
        'febd_num_2',
        'name_2',
        'last_name_2',
        // 'price',
        'dorsal',
        'pay',
        'method_pay',
        'state_pay',
        'state',
    ];

    /**
     * Los atributos que deberían estar ocultos para las matrices.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function prices()
    {
        return $this->belongsToMany(Price::class);
    }
}
