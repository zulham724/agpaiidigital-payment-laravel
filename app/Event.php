<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function event_guests()
    {
        return $this->hasMany('App\EventGuest');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'event_guests')->withPivot('created_at')->withTimestamps()->orderBy('created_at','desc');
    }
}
