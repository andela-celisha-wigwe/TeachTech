<?php

namespace TeachTech;

use Illuminate\Foundation\Auth\User as Authenticatable;
use TeachTech\Video;
use TeachTech\Comment;
use TeachTech\Favorite;

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

    public function owns(\Illuminate\Database\Eloquent\Model $model)
    {
        return $this->id == $model->user_id;
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

    public function canHandle($video)
    {
        return $this == $video->user;
    }

    public function cannnotHandle($video)
    {
        return !($this->owns($video));
        // return !($this->canHandle($video));
    }

    /**
    * Get all of the staff member's photos.
    */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favors(\Illuminate\Database\Eloquent\Model $model)
    {
        $liked = $this->favored($model);

        return $liked == null ? false : $liked->status;
    }

    public function favoritedVideos()
    {
        $videoLikes = $this->favorites()->where('favoritable_type', 'TeachTech\Video')->where('status', 1)->get();
        $results = array_map(function ($like) {
            return \TeachTech\Video::find($like['favoritable_id']);
        }, $videoLikes->toArray());

        return $results;

        // return $this->hasManyThrough('TeachTech\Video', 'TeachTech\Favorite', 'favoritable_id', 'user_id');
    }

    public function favored(\Illuminate\Database\Eloquent\Model $model)
    {
        return $this->favorites()->where('favoritable_id', $model->id)->where('favoritable_type', get_class($model))->first();
    }
}
