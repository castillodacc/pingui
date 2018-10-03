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
        'category_id',
        'level_id',
        'subcategory_id',
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

    public function subO()
    {
        return $this->belongsTo(Category_open::class, 'subcategory_id', 'id');
    }

    public function subL()
    {
        return $this->belongsTo(Subcategory_latino::class, 'subcategory_id', 'id');
    }

    public function subS()
    {
        return $this->belongsTo(Subcategory_standar::class, 'subcategory_id', 'id');
    }

    public function subHelp()
    {
        if ($this->category_id == 1) {
            return $this->subO;
        } elseif ($this->category_id == 2) {
            return $this->subL;
        } elseif ($this->category_id == 3) {
            return $this->subS;
        }
    }
}
