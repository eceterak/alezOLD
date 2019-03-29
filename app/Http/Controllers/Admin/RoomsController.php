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
     * Edit a room.
     * 
     * @param string $path
     * @return view
     */
    public function edit($path) 
    {
        $room = Room::getByPath($path);
        
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
    public function update($room) 
    {
        Room::getByPath($room)->update(request()->validate([
            'title' => 'required',
            'description' => 'required',
            'rent' => 'required',
            'city_id' => 'required'
        ]));

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
     * Create a new room.
     * 
     * @return redirect
     */
    public function store() 
    {
        auth()->user()->rooms()->create(request()->validate([
            'city_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'rent' => 'required'
        ]));

        return redirect(route('admin.rooms'));
    }
}
