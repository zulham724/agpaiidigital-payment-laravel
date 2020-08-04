<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemplateCategory extends Model
{
    public function users()
    {
        return $this->morphToMany('App\User','bookmark');
    }
}
