<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyPrayer extends Model
{
    //
    public function file(){
        return $this->morphOne('App\File','file');
    }
}
