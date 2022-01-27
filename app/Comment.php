<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Comment extends Model
 {      
    // 1つの投稿に対してなので単数形
    public function post()
    {
                            //  post.phpと紐づける
        return $this->belongsTo('APP\Post');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
