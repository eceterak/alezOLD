<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Room;
use App\City;

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
     * Display an edit form.
     * 
     * @param string $slug
     * @return view
     */
    public function edit($slug) 
    {
        return view('admin.rooms.edit')->with([
            'room' => Room::getBySlug($slug)
        ]);
    }

    /**
     * Update a room.
     * 
     * @param string slug
     * @param Request $request
     * @return redirect
     */
    public function update($slug, Request $request) 
    {
        $room = Room::getBySlug($slug);

        $room->update($this->validateRequest($request));

        $room->generateSlug();

        return redirect(route('admin.rooms'));
    }

    /**
     * Display new room form.
     * 
     * @return view
     */
    public function create() 
    {
        return view('admin.rooms.create');
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

        $room->generateSlug();

        return redirect(route('admin.rooms'));
    }


    /**
     * Validate a data.
     * 
     * @param Request $request
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
