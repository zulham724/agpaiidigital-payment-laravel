<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    //
    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function lesson_plan_likes(){
        return $this->hasMany('App\LessonPlanLike');
    }
}
