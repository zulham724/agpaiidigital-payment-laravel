<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    protected $guarded = ['id'];

    public function districts(){
    	return $this->hasMany('App\District');
    }

    public function users(){
        return $this->belongsToMany('App\User','profiles');
    }
}
