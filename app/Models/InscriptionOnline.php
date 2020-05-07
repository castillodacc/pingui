<?php

namespace App\Models;

use App\Traits\ModelsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InscriptionOnline extends Model
{
	use SoftDeletes, ModelsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'club',
    	'phone',
    	'email',
    	'coach',
    	'sex_id',
    	'country',
    	'birthdate',
    	'category_id',
        'inscription_id'
    ];

    /**
     * Los atributos que deberían estar ocultos para las matrices.
     *
     * @var array
     */
    protected $hidden = [
    	'created_at', 'updated_at', 'deleted_at'
    ];

}
