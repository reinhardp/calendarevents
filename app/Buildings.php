<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buildings extends Model
{
    //
	public function rooms() {
		return $this->hasMany(Rooms::class);
	}
}
