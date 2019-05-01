<?php

namespace App\Http\Controllers;

use App\Room;
use App\RoomFilters;
use Illuminate\Http\Request;

class RoomsController extends Controller
{

    /**
     * Display all available rooms.
     * 
     * To filter the results use RoomFilters which are injected trough route model binding.
     * 
     * @return view
     */
    public function index(RoomFilters $filters) 
    {
        return view('rooms.index')->with([
            'rooms' => Room::filter($filters)->get()
        ]);
    }

    /**
     * Display a single room.
     * 
     * @param string $path
     * @return view
     */
    public function show($city, $room) 
    {   
        return view('rooms.show')->with([
            'room' => Room::getByPath($room)
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
    public function update($path, Request $request) 
    {
        $room = Room::getByPath($path);

        $this->authorize('update', $room);

        $room->update($request->all());

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
    public function store(Request $request) 
    {
        auth()->user()->rooms()->create($this->validateRequest());

        return redirect(route('home'));
    }

    /**
     * Validate a data.
     * 
     * @return array
     */
    protected function validateRequest() 
    {
        return request()->validate([
            'city_id' => 'required',
            'street_id' => 'sometimes',
            'title' => 'required',
            'description' => 'required',
            'available_from' => 'sometimes',
            'minimum_stay' => 'sometimes',
            'maximum_stay' => 'sometimes',
            'landlord' => 'sometimes',
            'rent' => 'required',
            'deposit' => 'sometimes',
            'bills' => 'required',
            'property_type' => 'sometimes',
            'property_size' => 'sometimes',
            'living_room' => 'sometimes',
            'room_size' => 'sometimes',
            'furnished' => 'sometimes',
            'broadband' => 'sometimes',
            'smooking' => 'sometimes',
            'pets' => 'sometimes',
            'occupation' => 'sometimes',
            'couples' => 'sometimes',
            'gender' => 'sometimes',
            'minimum_age' => 'sometimes',
            'maximum_age' => 'sometimes'
        ]);
    }
}
