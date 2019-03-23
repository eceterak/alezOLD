<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;

class RoomsController extends Controller
{

    /**
     * 
     * 
     * @return view
     */
    public function index() 
    {
        $rooms = Room::all();
        
        return view('rooms.index')->withRooms($rooms);
    }

    /**
     * 
     * 
     * @return view
     */
    public function show(Room $room) 
    {        
        return view('rooms.show')->withRoom($room);
    }

    /**
     * 
     * 
     * @return view
     */
    public function edit(Room $room) 
    {    
        if(auth()->user()->isNot($room->user)) {
            abort(403);
        }
        
        return view('rooms.edit')->withRoom($room);
    }

    /**
     * 
     * 
     * @return
    */
    public function create() 
    {
        return view('rooms.create');
    }

    /**
     * 
     * 
     * @return redirect
     */
    public function store() {
        $attributes = request()->validate([
            'city_id' => 'required',
            'title' => 'required', 
            'description' => 'required', 
            'rent' => 'required'
        ]);

        auth()->user()->rooms()->create($attributes);

        return redirect('/pokoje');
    }
}
