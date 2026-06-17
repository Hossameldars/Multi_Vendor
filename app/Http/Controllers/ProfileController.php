<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Image;
use App\Traits\Trait_image;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\Intl\Countries;

class ProfileController extends Controller
{
  use Trait_image;
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('Dashboard.Profile.profile', [
            'user' => $request->user(),
            'countries'=>Countries::getNames()
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
    $user = Auth()->user();
    //$old_image=$user->image;
            $user->profile()->updateOrCreate(
          ['user_id' => $user->id],
    [
        'fisrt_name'     => $request->fisrt_name,
        'last_name'      => $request->last_name,
        'gender'         => $request->gender,
        'birthday'       => $request->birthday,
        'street_address' => $request->street_address,
        'city'           => $request->city,
        'state'          => $request->state,
        'postal_code'    => $request->postal_code,
        'country'        => $request->country,
        'locale'         => $request->locale,
    ]
  
       );
       
   $path = $this->image($request, 'profile');

    if ($path) {
        $old_image = $user->image; 

      
        if ($old_image) {
            Storage::disk('public')->delete($old_image->path);
        }

      
        $user->image()->updateOrCreate(
            [
                'imageable_id'   => $user->id,
                'imageable_type' => 'App\Models\User',
            ],
            [
                'path'           => $path,
                'imageable_id'   => $user->id,
                'imageable_type' => 'App\Models\User',
            ]
        );
    }
    
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
