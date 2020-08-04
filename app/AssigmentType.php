<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssigmentType extends Model
{
    //
    public function scopeSelectoptions($query){
        $query->where('description','=','selectoptions');
    }
}
