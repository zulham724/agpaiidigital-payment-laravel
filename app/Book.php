<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //
    protected $fillable = ['user_id','book_category_id','title','description'];

    public function book_category(){
        return $this->belongsTo('App\BookCategory');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
