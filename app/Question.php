<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $fillable = ['session_id','question_list_id','name','description','score'];

    public function answer(){
        return $this->hasOne('App\Answer');
    }
    public function answer_lists(){
        return $this->hasMany('App\AnswerList','question_list_id','question_list_id');
    }
    public function assigment_question_list(){
        return $this->hasOne('App\AssigmentQuestionList','question_list_id','question_list_id');
    }
    
}
