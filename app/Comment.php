<?php

namespace TeachTech;

use Illuminate\Database\Eloquent\Model;
use TeachTech\Video;
use TeachTech\User;
use Carbon\Carbon;

class Comment extends Model
{
    public $table = 'comments';

    public $fillable = [
        'comment',
    ];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentedAt()
    {
        return $this->created_at->diffForHumans();
    }

    public function favorites()
    {
        return $this->morphMany('TeachTech\Favorite', 'favoritable');
    }
}
