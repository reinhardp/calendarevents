<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['id', 'title', 'details', 'start', 'endd', 'starttime', 'endtime	'];
	
	public function rooms() {
		return $tis->belongsTo('App\Rooms', 'rooms_id');
	}
}
