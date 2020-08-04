<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerList extends Model
{
    //
    protected $fillable = ['name','value'];

    public function files(){
        return $this->morphMany('App\File','file');
    }
}
