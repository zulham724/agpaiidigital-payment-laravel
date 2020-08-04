<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    //

    public function profiles(){
    	return $this->hasMany('App\Profile');
    }

    public function users(){
        return $this->belongsToMany('App\User','profiles');
    }
}
