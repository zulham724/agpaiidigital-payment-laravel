<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    //

    public function type(){
        return $this->morphOne('App\Type','type');
    }
}
