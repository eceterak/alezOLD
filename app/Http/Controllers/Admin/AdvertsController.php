<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAdvertRequest;
use App\Http\Requests\UpdateAdvertRequest;
use Illuminate\Support\Facades\Input;
use App\Filters\AdminAdvertFilters;
use App\Advert;

class AdvertsController extends Controller
{

    /**
     * Display all adverts.
     * 
     * @return view
     */
    public function index(AdminAdvertFilters $filters) 
    {
        $adverts = Advert::latest()->filter($filters);

        return view('admin.adverts.index')->with([
            'adverts' => $adverts->paginate(24)->appends(Input::except('page'))
        ]);
    }

    /**
     * Display new Advert form.
     * 
     * @return view
     */
    public function create() 
    {
        return view('admin.adverts.create');
    }

    /**
     * Display an edit form.
     * 
     * @param Advert $advert
     * @return view
     */
    public function edit(Advert $advert) 
    {
        return view('admin.adverts.edit')->with([
            'advert' => $advert->load(array('photos' => function($query) {
                $query->orderBy('order', 'asc');
            }))
        ]);
    }

    /**
     * Store a new Advert in a database.
     * 
     * @param Request $request
     * @return redirect
     */
    public function store(CreateAdvertRequest $request) 
    {
        $advert = auth()->user()->adverts()->create($request->validated());

        return redirect(route('admin.adverts'));
    }

    /**
     * Update a Advert.
     * 
     * @param Advert $advert
     * @param Request $request
     * @return redirect
     */
    public function update(Advert $advert, UpdateAdvertRequest $request) 
    {
        $advert->update($request->validated());

        return redirect(route('admin.adverts'));
    }

    /**
     * Delete a Advert.
     * 
     * @return redirect
     */
    public function destroy(Advert $advert) 
    {
        $advert->archive();

        if(request()->expectsJson())
        {
            return response(['status' => 'Ogłoszenie usunięte']); // @refactor - vue component
        }
     
        return redirect(route('admin.adverts'));
    }
}
