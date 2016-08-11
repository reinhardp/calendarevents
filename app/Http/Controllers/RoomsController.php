<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Rooms;

class RoomsController extends Controller
{
    public function resources() {
		$rooms = Rooms::orderBy('id', 'asc')
		->get();

		return json_encode($rooms);

	}
}
