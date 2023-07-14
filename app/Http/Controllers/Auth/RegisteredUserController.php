<?php

namespace App\Http\Controllers\Auth; 

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Http\Requests\Auth\RegisteredUserRequest;
use App\Models\User;

require_once __DIR__ . '../../../../../config/Data_For_Seeding/bnb_api_client_functions.php';


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisteredUserRequest $request): RedirectResponse
    {
        // $all_apartments_data_json = get_coordinates("Piazza dei Giuochi, /1", "Andria");
        // $all_apartments_data = json_decode($all_apartments_data_json,true);
        // $first = $all_apartments_data['results'][0];
        // dd($first['position']);
        // dd(get_coordinates("Hotel Ottagono", "Andria")['results']);
        $request->validated();
        // dd($request);
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'surname' => $request->surname,
            'birth' => $request->birth,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
