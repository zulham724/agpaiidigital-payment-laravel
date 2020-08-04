<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EducationalLevel extends Model
{
    //
    protected $guarded = ['id'];

    public function lesson_plan_formats()
    {
        return $this->hasMany('App\LessonPlanFormat');
    }

    public function grades()
    {
        return $this->hasMany('App\Grade');
    }

    public function lesson_plans(){
        return $this->hasManyThrough('App\LessonPlan','App\Grade');
    }

    public function users(){
        return $this->belongsToMany('App\User','profiles');
    }
}
