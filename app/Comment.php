<?php

namespace App;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable=['user_id', 'content'];

    // blog_post_id!!
    public function blogPost() {
        return $this->belongsTo('App\BlogPost');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function scopeLatest(Builder $query) {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public static function boot() {
        parent::boot();

        //static::addGlobalScope(new LatestScope);
    }
}
