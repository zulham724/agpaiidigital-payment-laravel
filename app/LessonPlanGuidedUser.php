<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LessonPlanGuidedUser extends Model
{
    //

    public function parent(){
        return $this->belongsTo('App\User','parent_id','id');
    }

    public function child(){
        return $this->belongsTo('App\User','child_id','id');
    }
}
