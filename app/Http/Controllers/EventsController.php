<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Event;
use App\Rooms;
use App\Buildings;
use Input;

use Log;

class EventsController extends Controller
{
    public function getEvents() {
        $events = Event::all();
		foreach ($events as $event) {
			  $room = Rooms::find($event->resourceId);
			  $building = Buildings::find($room->building_id);
			  $event->title_real = $event->title;
			  //$event->title .= ' (Raum: ' . $event->resource . ' Gebäude: ' . $building->name . ')';
			  $event->building = $building->name;
			  $event->roomname = $event->resource;
			  $event->details_real = $event->details;
			  
		}
        return json_encode($events);
    }

    public function getEvent() {
		
        $event = Event::find(Input::get('id'));

        return json_encode($event);
    }

    public function setEvent(Request $request) {
        $result = ['success' => false];
        $input = Input::all();
        if(isset($input['id']) && !empty($input['id']) && Event::find($input['id'])) {
		
            $event = Event::find($input['id']);
            if($event) {
				$room = Rooms::find($request->room);
                //$event->update($input);
				$event->title = $request->title;
				$event->start = $request->start . " " . $request->starttime;
				$event->end = $request->end . " " . $request->endtime;
				$event->starttime = $request->starttime;
				$event->endtime = $request->endtime;
				$event->details = $request->details;
				$event->resourceid = $request->room;
				$event->resource = $room->title;
				$event->save();
                $result['event'] = $event;
                $result['success'] = true;
            }
        }
        else {
			
			//Log::info('Checkbox: ' . $request->allDay);
            //$event = Event::create($input);
			$room = Rooms::find($request->room);
			$event = new Event;
			$event->title = $request->title;
			$event->start = $request->start . " " . $request->starttime;
			$event->end = $request->end . " " . $request->endtime;
			$event->starttime = $request->starttime;
			$event->endtime = $request->endtime;
			$event->details = $request->details;
			$event->resourceid = $request->room;
			$event->resource = $room->title;
			$event->save();
            $result['event'] = $event;
            $result['success'] = true;
			
        }

        return json_encode($result);
    }

    public function deleteEvent(Request $request) {
        $result = ['success' => false];
        $id = Input::get('id');

        if(isset($id) && !empty($id) && Event::find($id)) {
            $event = Event::find($id);
            $event->delete();

            $result['success'] = true;
        }
        return json_encode($result);
    }
}
