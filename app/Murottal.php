<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Murottal extends Model
{
    //
    public function file(){
        return $this->morphOne('App\File','file');
    }
}
