<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    public function modul_contents(){
        return $this->hasMany('App\ModuleContent');
    }
}
