<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function blogPosts() {
        //return $this->belongsToMany('App\BlogPost')->withTimestamps();
        return $this->morphedByMany('App\BlogPost', 'taggable')->withTimestamps()->as('tagged');
    }

    public function comments() {
        //return $this->belongsToMany('App\BlogPost')->withTimestamps();
        return $this->morphedByMany('App\Comment', 'taggable')->withTimestamps()->as('tagged');
    }
}
