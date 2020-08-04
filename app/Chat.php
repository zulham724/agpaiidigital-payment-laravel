<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    //

    public function channels(){
        return $this->belongsToMany('App\Channel','chat_channels');
    }

    public function main_users(){
        return $this->belongsToMany('App\User','main_chats');
    }
}
