<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
            'bio' => 'sometimes'
        ]);

        if(request()->has('email_notifications')) $attributes['email_notifications'] = true;
        else $attributes['email_notifications'] = false;

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

        redirect()->route('index')->with('flash', 'Konto zostało usunięte.');
    }
}
