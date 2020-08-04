<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LessonPlan extends Model
{
    //
    // protected $guarded = ["id"];
    protected $fillable = ["user_id",'creator_id','image','topic','school','subject','grade_id','duration','effort','lesson_plan_cover_id','description','is_lock'];

    public function contents(){
        return $this->hasMany('App\LessonPlanContent');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function grade(){
        return $this->belongsTo('App\Grade');
    }

    public function comments(){
        return $this->belongsToMany('App\Comment','lesson_plan_comments','lesson_plan_id','comment_id');
    }

    public function reviews(){
        return $this->belongsToMany('App\Review','lesson_plan_reviews','lesson_plan_id','review_id');
    }


    public function likes(){
        return $this->belongsToMany('App\Like','lesson_plan_likes');
    }

    public function liked(){
        return $this->belongsToMany('App\Like','lesson_plan_likes')->where('user_id', Auth::user()->id);
    }

    public function ratings(){
        return $this->belongsToMany('App\Rating','lesson_plan_ratings');
    }

    public function rated(){
        return $this->belongsToMany('App\Rating','lesson_plan_ratings')->where('user_id', Auth::user()->id);
    }

    public function cover(){
        return $this->belongsTo('App\LessonPlanCover','lesson_plan_cover_id','id');
    }

}
