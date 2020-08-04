<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LessonPlanRating extends Model
{
    //

    public function rating(){
        return $this->belongsTo('App\Rating');
    }

    public function lesson_plan(){
        return $this->belongsTo('App\Lessonplan');
    }
}
