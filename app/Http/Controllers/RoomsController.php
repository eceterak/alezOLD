<?php

namespace App\Http\Controllers;

use App\Room;
use App\RoomFilters;
use Illuminate\Http\Request;

class RoomsController extends Controller
{

    /**
     * Display all available rooms.
     * To filter the results use RoomFilters which are injected trough route model binding.
     * 
     * @param RoomFilters $filters
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
     * @param string $city
     * @param string $slug
     * @return view
     */
    public function show($city, $slug) 
    {   
        return view('rooms.show')->with([
            'room' => Room::getBySlug($slug)
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
        $room = Room::getBySlug($path);
        
        $this->authorize('update', $room);

        return view('rooms.edit')->with([
            'room' => $room
        ]);
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
     * Store a new room in a database.
     * 
     * @param Request $request
     * @return redirect
     */
    public function store(Request $request) 
    {
        $room = auth()->user()->rooms()->create($this->validateRequest($request));

        return redirect(route('home'));
    }

    /**
     * Update a room.
     * 
     * @param string $slug
     * @param Request $request
     * @return redirect
     */
    public function update($slug, Request $request) 
    {
        $room = Room::getBySlug($slug);
        
        $this->authorize('update', $room);

        $room->update($this->validateRequest($request));

        $room->generateSlug();

        return redirect(route('rooms'));
    }

    /**
     * Delete a room. Accept id instead of slug.
     * 
     * @param Room $room
     * @return redirect
     */
    public function destroy(Room $room) 
    {
        $this->authorize('update', $room);

        $room->delete();
     
        return redirect(route('home'));        
    }

    /**
     * Validate a request.
     * 
     * @param Request $request
     * @return array
     */
    protected function validateRequest($request) 
    {
        return request()->validate([
            'city_id' => 'required',
            'street_id' => 'sometimes',
            'title' => 'required',
            'description' => 'required',
            'available_from' => 'nullable',
            'minimum_stay' => 'nullable',
            'maximum_stay' => 'nullable',
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
            'smoking' => 'sometimes',
            'pets' => 'sometimes',
            'occupation' => 'sometimes',
            'couples' => 'sometimes',
            'gender' => 'sometimes',
            'minimum_age' => 'sometimes',
            'maximum_age' => 'sometimes'
        ]);
    }
}
