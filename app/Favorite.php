<?php

namespace TeachTech;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{

	protected $fillable = [
		'user_id',
	];

    public function favoritable()
    {
        return $this->morphTo();
    }

    public function favoriter()
    {
        return $this->belongsTo('User');
    }
}
