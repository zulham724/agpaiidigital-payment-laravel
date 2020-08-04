<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    public function templatable()
    {
        return $this->morphTo();
    }
    //
    public function template_category(){
        return $this->hasOne('App\TemplateCategory');
    }
}
