<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    //
    protected $fillable = ['user_id','value'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function lesson_plan_ratings(){
        return $this->hasMany('App\LessonPlanRating');
    }

    public function lesson_plans(){
        return $this->belongsToMany('App\LessonPlan','lesson_plan_ratings');
    }
}
