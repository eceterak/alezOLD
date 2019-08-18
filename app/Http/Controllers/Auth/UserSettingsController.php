<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserSettingsController extends Controller
{
    /**
     * Display user settings page.
     * 
     * @return
     */
    public function index() 
    {
        return view('users.settings')->with([
            'profile' => auth()->user()
        ]);
    }

    /**
     * Update user profile.
     * @refactor?
     * 
     * @return redirect
     */
    public function update() 
    {
        $attributes = request()->validate([
            'bio' => 'sometimes',
            'phone' => 'sometimes|digits_between:9,13'
        ]);

        if(request()->has('email_notifications')) $attributes['email_notifications'] = true;
        else $attributes['email_notifications'] = false;

        if(request()->has('hide_phone')) $attributes['hide_phone'] = true;
        else $attributes['hide_phone'] = false;

        auth()->user()->update($attributes);

        return redirect()->route('settings')->with('flash', 'Ustawienia zostały zapisane');
    }

    /**
     * Delete account.
     * 
     * @return redirect
     */
    public function destroy() 
    {
        auth()->user()->deleteAccount();

        return redirect()->route('index')->with('flash', 'Konto zostało usunięte.');
    }
}
