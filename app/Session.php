<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    //
    protected $fillable = ['user_id','value'];

    public function sessionable(){
        return $this->morphTo();
    }

    // public function assigment(){
    //     return $this->belongsTo('App\Assigment','session_id');
    // }

    public function assigments(){
        return $this->belongsToMany('App\Assigment','assigment_sessions')->withPivot('total_score','user_id');
    }

    public function questions(){
        return $this->hasMany('App\Question');
    }

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
    public function assigment_session(){
        return $this->hasOne('App\AssigmentSession');
    }
}
