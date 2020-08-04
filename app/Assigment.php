<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Assigment extends Model
{
    //
    protected $fillable = ['user_id', 'teacher_id', 'grade_code', 'grade_id','assigment_category_id','topic','subject','indicator','password','start_at','end_at','description','note','timer','code','is_publish','semester','education_year','name','is_public'];

    public function grade(){
        return $this->belongsTo('App\Grade');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
    //mengambil teacher (pemberi soal), bukan user (pembuat soal)
    public function teacher(){
        return $this->belongsTo('App\User', 'teacher_id');   
    }

    public function assigment_category(){
        return $this->belongsTo('App\AssigmentCategory');
    }

    public function comments(){
        return $this->belongsToMany('App\Comment','App\AssigmentComment');
    }

    public function likes()
    {
        return $this->belongsToMany('App\Like', 'App\AssigmentLike')->withPivot('created_at')->withTimestamps();
    }

    public function liked()
    {
        return $this->belongsToMany('App\Like', 'App\AssigmentLike')->withPivot('created_at')->withTimestamps()->where('user_id', Auth::user()->id);
    }

    public function ratings(){
        return $this->belongsToMany('App\Rating','App\AssigmentRating');
    }

    public function reviews(){
        return $this->belongsToMany('App\Review','App\AssigmentReview');
    }

    public function question_lists(){
        return $this->belongsToMany('App\QuestionList','App\AssigmentQuestionList')->withPivot('creator_id','user_id','assigment_type_id');
    }
    
    public function question_lists_select_options_only(){
        return $this->belongsToMany('App\QuestionList','App\AssigmentQuestionList','assigment_id','question_list_id')->withPivot('creator_id','user_id','assigment_type_id')->wherePivot('assigment_type_id',\App\AssigmentType::where('description','=','selectoptions')->get()->map(function($data){
            return $data->id;
        }));
    
    }
    

    // public function sessions(){
    //     return $this->morphMany('App\Session','session');
    // }

    public function sessions(){
        return $this->belongsToMany('App\Session','App\AssigmentSession')->withPivot('total_score','user_id');
    }
    public function assigment_sessions(){
        return $this->hasMany('App\AssigmentSession');
    }
    public function assigment_session(){
        return $this->hasOne('App\AssigmentSession','assigment_id')->orderBy('assigment_sessions.id','desc'); //orderBy id DESC agar mengambil data terbaru dari user sekarang
    }
    public function auth_sessions(){
        return $this->belongsToMany('App\Session','App\AssigmentSession')->withPivot('total_score','user_id')->where('sessions.user_id',Auth::user()->id)->orderBy('sessions.id','desc');
    }
    public function latest_auth_session(){
        return $this->auth_sessions()->limit(1);
    }
}
