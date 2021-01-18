<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

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
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;
        return view('profiles.index', compact('user', 'follows'));
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

        # if the request has an image
        if(request('image')) {
            $imagePath = request('image')->store('profile', 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();
            $imageArray = ['image' => $imagePath];
        }


        # grabbing only the authenticated user
        # extra layer of protection

        auth()->user()->profile->update(array_merge(
            $data,
            $imageArray ?? []
        ));

        return redirect("profile/{$user->id}");
    }
}
