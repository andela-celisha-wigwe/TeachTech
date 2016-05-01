<?php

namespace TeachTech;

use Illuminate\Database\Eloquent\Model;
use TeachTech\User;
use TeachTech\Category;
use TeachTech\Comment;
use TeachTech\Favorite;

class Video extends Model
{
    protected $fillable = [
        'title', 'url', 'description', 'category'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function vID()
    {
        $p = (explode('=', $this->url));
        return end($p);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function urlHost()
    {
        preg_match('@^(?:http://)?(?:https://)?([^/]+)@i', $this->url, $matches);
        $host = $matches[1];
        return $host;
    }

    public function srcFrame()
    {
        $srcFrame = "http://" . $this->urlHost() . '/embed/' . $this->vID();
        return $srcFrame;
    }

    public function shortTitle()
    {
        return substr($this->title, 0, 10);
    }

    public function favorites()
    {
        return $this->morphMany('TeachTech\Favorite', 'favoritable');
    }
}
