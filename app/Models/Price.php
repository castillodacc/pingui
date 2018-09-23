<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelsTrait;

class Price extends Model
{
	use SoftDeletes, ModelsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'category_id',
        'category_text',
        'category1_id',
        'category1_text',
        'subcategory_id',
        'subcategory_text',
        'price',
        'tournament_id',
    ];

    /**
     * Los atributos que deberían estar ocultos para las matrices.
     *
     * @var array
     */
    protected $hidden = [
    	'created_at', 'updated_at', 'deleted_at'
    ];

    public function inscriptions()
    {
        return $this->belongsToMany(Inscription::class);
    }
}
