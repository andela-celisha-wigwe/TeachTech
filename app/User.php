<?php

namespace TeachTech;

use Illuminate\Foundation\Auth\User as Authenticatable;
use TeachTech\Video;
use TeachTech\Comment;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'social_link', 'social_id', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function isOwner($id)
    {
        return $this->id === (Video::find($id))->user_id;
    }

    public function isCommenter($id)
    {
        $comment = Comment::find($id);
        return $this->id == $comment->user_id;
    }

    public function numberOfVidoes()
    {
        return count($this->videos);
    }

    public function getAvatar()
    {
        return $this->hasAvatar() ? $this->avatar : asset('uploads/def_profile.png');
    }

    private function hasAvatar()
    {
        return $this->avatar != null;
    }
}
