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
    public function index(User $user)
    {

        // $user = User::findOrFail($user);
        // return view('profiles.index', [
        //     'user' => $user
        // ]);
        return view('profiles.index', compact('user'));
    }

    public function edit(User $user)
    {
        // authorized user can only view his edit profile page
        $this->authorize('update', $user->profile);
        return view('profiles.edit', compact('user'));
    }

    public function update(User $user)
    {
        // authorized user can only update his profile
        $this->authorize('update', $user->profile);
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => ''
        ]);

        # grabbing only the authenticated user
        # extra layer of protection
        auth()->user()->profile->update($data);
        return redirect("profile/{$user->id}");
    }
}
