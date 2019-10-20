<?php

namespace App;

use App\Scopes\DeletedAdminScope;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    //protected $table='blogpost';

    use SoftDeletes;

    protected $fillable=['title', 'content', 'user_id'];

    public function comments() {
        return $this->morphMany('App\Comment', 'commentable')->latest();
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function tags() {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }

    public function scopeLatest(Builder $query) {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public function scopeMostCommented(Builder $query)
    {
        //comments_count
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public function scopeLatestWithRelations(Builder $query)
    {
        return $query->latest()
                ->withCount('comments')
                ->with('user')
                ->with('tags');
    }

    public static function boot() {

        static::addGlobalScope(new DeletedAdminScope);

        parent::boot();

        static::deleting(function(BlogPost $blogPost) {
            $blogPost->comments()->delete();
            //$blogPost->image()->delete();
        });

        static::restoring(function (BlogPost $blogPost) {
            $blogPost->comments()->restore();
        });
    }
}
