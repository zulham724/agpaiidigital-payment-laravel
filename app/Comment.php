<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    //
    protected $fillable = ["user_id", "value"];

    // public function likes()
    // {
    //     return $this->belongsToMany('App\Like', "App\CommentLike")->withPivot('created_at')->withTimestamps();
    // }

    public function likes(){
        return $this->morphMany('App\Like','like');
    }

    // public function liked()
    // {
    //     return $this->belongsToMany('App\Like', "App\CommentLike")->withPivot('created_at')->withTimestamps()->where('user_id', Auth::user()->id);
    // }

    public function liked(){
        return $this->morphOne('App\Like','like')->where('user_id', Auth::check() ? Auth::user()->id : 0);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function lesson_plans(){
        return $this->belongsToMany('App\LessonPlan','lesson_plan_comments');
    }
}
