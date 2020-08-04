<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionList extends Model
{
    //
    protected $fillable = ['name','description'];

    public function answer_lists(){
        return $this->hasMany('App\AnswerList');
    }

    public function assigments(){
        return $this->belongsToMany('App\Assigment','App\AssigmentQuestionList')->withPivot('creator_id','user_id','assigment_type_id');
    }
    public function assigment_question_lists(){
        return $this->hasMany('App\AssigmentQuestionList');
    }
    public function assigment_question_list(){
        return $this->hasOne('App\AssigmentQuestionList');
    }

    public function files(){
        return $this->morphMany('App\File','file');
    }

}
