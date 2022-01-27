<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{   //コメントは複数だからcomments
    public function comments()
    {                             //Comment.phpと紐づける
        return $this->hasMany('App\Comment');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
