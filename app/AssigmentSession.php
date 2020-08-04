<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class AssigmentSession extends Model
{
    //
    protected $fillable = ['user_id','total_score'];

    public function assigment(){
        return $this->belongsTo('App\Assigment');
    }

    public function session(){
        return $this->belongsTo('App\Session');
    }
    public function latest_session(){
        return $this->belongsTo('App\Session','session_id')->where('sessions.user_id', Auth::user()->id);
    }
}
