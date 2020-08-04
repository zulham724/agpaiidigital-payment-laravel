<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LessonPlanContent extends Model
{
    //
    // protected $guarded = ["id"];
    protected $fillable = ["name","value"];
}
