<?php

namespace TeachTech;

use Illuminate\Database\Eloquent\Model;
use TeachTech\User;
use TeachTech\Video;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name', 'brief',
    ];

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function numberOfVideos()
    {
    	return count($this->videos()->get());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
