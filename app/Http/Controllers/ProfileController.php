<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request, User $userm): RedirectResponse
    {
       
 
    $startingUser = Auth::user();
    
    $user = $request->user();
    
    $user->fill($request->validated());
    
    
    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }
    
    $user->save();
    
    //verifica la modifica dei dati di partenza
    if(!empty($user->getChanges())){

        return Redirect::route('admin.profile.edit')->with('status', 'profile-updated');

    } else {

        return Redirect::route('admin.profile.edit')->with('status', 'profile-not-changed');
       
    }
    
    return Redirect::route('admin.profile.edit')->with('status', 'profile-updated');

    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
