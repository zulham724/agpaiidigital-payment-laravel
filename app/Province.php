<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    //
    protected $guarded = ['id'];

    public function cities(){
    	return $this->hasMany('App\City');
    }

    public function users(){
        return $this->belongsToMany('App\User','profiles');
    }
}
