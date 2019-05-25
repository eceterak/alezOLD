<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordChangeController extends Controller
{
    /**
     * Display change password form.
     * 
     * @return view
     */
    public function index() 
    {
        return view('auth.passwords.change')->with([
            'profile' => auth()->user()
        ]);
    }

    /**
     * Change the password and redirect to the home page.
     * 
     * @return redirect
     */
    public function update(Request $request) 
    {
        $request->validate([
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::find(auth()->id());

        $user->password = Hash::make(request('password'));

        $user->setRememberToken(Str::random(60));

        $user->save();

        return redirect(route('home'))->with('flash', 'Hasło zostało zmienione');
    }

}
