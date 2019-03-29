<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;

class RoomsController extends Controller
{

    /**
     * Display all available rooms.
     * 
     * @return view
     */
    public function index() 
    {
        $rooms = Room::all();
        
        return view('rooms.index')->withRooms($rooms);
    }

    /**
     * Display a single room.
     * 
     * @param string $path
     * @return view
     */
    public function show($city, $room) 
    {
        $room = Room::getByPath($room);
        
        return view('rooms.show')->with([
            'room' => $room
        ]);
    }
    
    /**
     * Edit a room.
     * 
     * @param string $path
     * @return view
     */
    public function edit($path) 
    {
        $room = Room::getByPath($path);
        
        $this->authorize('update', $room);

        return view('admin.rooms.edit')->with([
            'room' => $room
        ]);
    }

    /**
     * Update a room.
     * 
     * @param string $romm
     * @return redirect
     */
    public function update($path) 
    {
        $room = Room::getByPath($path);

        $this->authorize('update', $room);

        $room->update(request()->validate([
            'title' => 'required',
            'description' => 'required',
            'rent' => 'required',
            'city_id' => 'required'
        ]));

        return redirect(route('rooms'));
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
