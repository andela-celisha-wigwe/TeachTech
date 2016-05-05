<?php

namespace TeachTech;

use Illuminate\Database\Eloquent\Model;
use TeachTech\User;

class Favorite extends Model
{

	protected $fillable = [
		'user_id',
	];

    public function favoritable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favoriter()
    {
        return $this->favoriter = $this->user;
    }
}
