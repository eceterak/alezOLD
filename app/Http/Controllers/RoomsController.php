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
     * Update a room.
     * 
     * @param Request $request
     * @param string $romm
     * @return redirect
     */
    public function update($path, Request $request) 
    {
        $room = Room::getBySlug($path);
        
        $this->authorize('update', $room);

        $room->update($this->validateRequest($request));

        $room->generateSlug();

        return redirect(route('rooms'));
    }

    /**
     * Store a new form in database.
     * 
     * @param Request $request
     * @return redirect
     */
    public function store(Request $request) 
    {
        //dd($this->validateRequest($request));

        $room = auth()->user()->rooms()->create($this->validateRequest($request));

        $room->generateSlug();

        return redirect(route('home'));
    }

    /**
     * Validate a data.
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
