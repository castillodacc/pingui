<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelsTrait;

class Tournament extends Model
{
	use SoftDeletes, ModelsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'start',
        'end',
        'inscription',
        'organizer_id',
        'image',
        'show_hour',
        'results',
        'hours',
        'maps',
        'info',
        // 'price',
        // 'entrance_price',
        'record_id',
        'type_id'
    ];

    /**
     * Los atributos que deberían estar ocultos para las matrices.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    public function moreInfo()
    {
        return $this->hasMany(MoreInfo::class);
    }

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    public function referees()
    {
        return $this->belongsToMany(Referee::class);
    }

    public function category_opens()
    {
        return $this->belongsToMany(Category_open::class);
    }

    public function subcategory_latinos()
    {
        return $this->belongsToMany(Subcategory_latino::class);
    }

    public function subcategory_standars()
    {
        return $this->belongsToMany(Subcategory_standar::class);
    }
}
