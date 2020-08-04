<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Passport\HasApiTokens;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use HasApiTokens,Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'kta_id', 'user_activated_at', 'avatar', 'role_id',
        'point'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function payment()
    {
        return $this->hasOne('App\Payment');
    }

    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    public function payments()
    {
        return $this->hasMany('App\Payment');
    }

    public function guest_events()
    {
        return $this->belongsToMany('App\Event', 'event_guests', 'user_id', 'event_id')->withTimeStamps();
    }

    public function events()
    {
        return $this->hasMany('App\Event');
    }

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function lesson_plans()
    {
        return $this->hasMany('App\LessonPlan');
    }

    public function posts()
    {
        return $this->hasMany('App\Post', 'author_id', 'id');
    }

    public function lesson_plans_likes(){
        return $this->hasManyThrough('App\LessonPlanLike','App\LessonPlan')->whereHas('like',function($query){
            $query->where('user_id','!=',Auth::user()->id);
        });
    }

    public function lesson_plans_ratings(){
        return $this->hasManyThrough('App\LessonPlanRating','App\LessonPlan')->whereHas('rating',function($query){
            $query->where('user_id','!=',Auth::user()->id);
        });
    }

    public function lesson_plans_my_likes(){
        return $this->hasManyThrough('App\LessonPlanLike','App\LessonPlan')->whereHas('like',function($query){
            $query->where('user_id',Auth::user()->id);
        });
    }

    public function lesson_plans_my_ratings(){
        return $this->hasManyThrough('App\LessonPlanRating','App\LessonPlan')->whereHas('rating',function($query){
            $query->where('user_id',Auth::user()->id);
        });
    }

    public function lesson_plans_comments(){
        return $this->hasManyThrough('App\LessonPlanComment','App\LessonPlan');
    }

    public function books(){
        return $this->hasMany('App\Book');
    }

    public function main_chats(){
        return $this->belongsToMany('App\Chat','main_chats')->withPivot('isAdmin');
    }

    public function chat_channels(){
        return $this->belongsToMany('App\Channel','chat_channels');
    }

    public function ratings(){
        return $this->hasMany('App\Rating');
    }

    public function lesson_plan_guided_users(){
        return $this->belongsToMany('App\User','lesson_plan_guided_users','parent_id','child_id')->withTimestamps();
    }

    public function lesson_plan_guided_parent(){
        return $this->belongsTo('App\LessonPlanGuidedUser','id','parent_id');
    }

    public function follows(){
        return $this->belongsToMany('App\User','follows','parent_id','child_id')->withTimestamps();
    }

    public function follower(){
        return $this->belongsToMany('App\User','follows','child_id','parent_id')->withTimestamps();
    }

    public function lesson_plan_guided_child(){
        return $this->belongsTo('App\LessonPlanGuidedUser','id','child_id');
    }

    public function assigments(){
        return $this->hasMany('App\Assigment');
    }

    public function given_assigments(){
        return $this->hasMany('App\Assigment','teacher_id','id');
    }

    public function publish_assigments(){
        return $this->hasMany('App\Assigment')->where('is_publish',true);
    }

    public function unpublish_assigments(){
        return $this->hasMany('App\Assigment')->where('is_publish',false);
    }

    public function bookmark_posts(){
        return $this->morphedByMany('App\Post','bookmark');
    }

    public function sessions(){
        return $this->hasMany('App\Session');
    }

    public function assigment_sessions(){
        return $this->hasMany('App\AssigmentSession');
    }
    public function modules(){
        return $this->hasMany('App\Module');
    }
    /////modul////
    public function templates(){
        return $this->belongsToMany('App\Template','user_templates','user_id','template_id');
    }
    public function template_categories(){
        return $this->morphedByMany('App\TemplateCategory','bookmark');
    }
}
