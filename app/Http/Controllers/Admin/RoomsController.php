<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Room;

class RoomsController extends Controller
{

    /**
     * Display all rooms for rent.
     * 
     * @return view
     */
    public function index() 
    {
        $rooms = Room::latest()->get();

        return view('admin.rooms.index')->with([
            'rooms' => $rooms
        ]);
    }

    /**
     * 
     * 
     * @return
     */
    public function edit($city, $room) 
    {
        $room = Room::where('id', substr($room, strpos($room, 'uuid-', 1) + 5))->firstOrFail();
        
        return view('admin.rooms.edit')->with([
            'room' => $room
        ]);
    }

    /**
     * Create a new room.
     * 
     * @return view
     */
    public function create() 
    {
        return view('admin.rooms.create');
    }

    /**
     * Store an room.
     * 
     * @return redirect
     */
    public function store() 
    {
        $attributes = request()->validate([
            'city_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'rent' => 'required'
        ]);

        auth()->user()->rooms()->create($attributes);

        return redirect(route('admin.rooms'));
    }
}
