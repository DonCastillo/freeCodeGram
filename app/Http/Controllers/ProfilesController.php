<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    /**
     * $user    name/identifier of the user as provided by 
     *          /profile/{user}
     */
    public function index($user)
    {
        //dd($user);
        $user = User::find($user);
        return view('home', [
            'user' => $user
        ]);
    }
}
