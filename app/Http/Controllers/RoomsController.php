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

        return view('rooms.edit')->with([
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

        $room->update($this->validateRequest());

        return redirect(route('rooms'));
    }


    /**
     * Display a create new room form.
     * 
     * @return view
     */
    public function create() 
    {
        return view('rooms.create');
    }

    /**
     * Store a new form in database.
     * 
     * @return redirect
     */
    public function store() 
    {
        auth()->user()->rooms()->create($this->validateRequest());

        return redirect('/pokoje');
    }

    /**
     * Validate a data.
     * 
     * @return array
     */
    protected function validateRequest() 
    {
        return request()->validate([
            'place_id' => 'required',
            'city_id' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'address' => 'required',

            'property_size' => 'required',
            'property_type_id' => 'required',
            'user_status' => 'required',

            'living_room' => 'required',


            'title' => 'required', 
            'description' => 'required', 
            'rent' => 'required'
        ]);
    }
}
