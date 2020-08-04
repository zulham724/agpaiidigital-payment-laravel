<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssigmentQuestionList extends Model
{
    //
  
    public function assigment_type(){
        return $this->belongsTo('App\AssigmentType');
    }

    public function creator(){
        return $this->belongsTo('App\User');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function assigment(){
        return $this->belongsTo('App\Assigment');
    }
    public function assigment_type_selectoptions_only(){
        return $this->belongsTo('App\AssigmentType','assigment_type_id')->where('description','=','selectoptions');
    }
}   
