<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    //
    const PUBLISHED = 'PUBLISHED';
    // protected $guarded = ["id"];
    protected $fillable = ['author_id','category_id','title','seo_title','excerpt','body','image','slug','meta_description','meta_keywords','status','featured'];

    public function authorId()
    {
        return $this->belongsTo('App\User', 'author_id', 'id');
    }

    public function save(array $options = [])
    {
        // If no author has been assigned, assign the current user's id as the author of the post
        if (!$this->author_id && app('VoyagerAuth')->user()) {
            $this->author_id = app('VoyagerAuth')->user()->getKey();
        }

        parent::save();
    }

    public function scopePublished(Builder $query)
    {
        return $query->where('status', '=', 'PUBLISHED');
    }

    // public function comments()
    // {
    //     return $this->belongsToMany('App\Comment', 'App\PostComment')->withPivot('created_at')->withTimestamps();
    // }

    public function comments(){
        return $this->morphMany('App\Comment','comment');
    }

    // public function likes()
    // {
    //     return $this->belongsToMany('App\Like', 'App\PostLike')->withPivot('created_at')->withTimestamps();
    // }

    public function likes(){
        return $this->morphMany('App\Like','like');
    }

    // public function liked()
    // {
    //     return $this->belongsToMany('App\Like', 'App\PostLike')->withPivot('created_at')->withTimestamps()->where('user_id', Auth::user()->id);
    // }

    public function liked(){
        return $this->morphOne('App\Like','like')->where('user_id', Auth::check() ? Auth::user()->id : 0);
    }

    public function bookmarked(){
        return $this->morphOne('App\Bookmark','bookmark')->where('user_id',Auth::check() ? Auth::user()->id : 0);
    }

    public function bookmarks(){
        return $this->morphMany('App\Bookmark','bookmark');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function files(){
        return $this->morphMany('App\File','file');
    }
}
