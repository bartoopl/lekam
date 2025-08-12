<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

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
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20'],
            'user_type' => ['required', 'string', 'in:farmaceuta,technik_farmacji'],
            'pwz_number' => ['required', 'string', 'max:20'],
            'pharmacy_address' => ['required', 'string', 'max:500'],
            'pharmacy_postal_code' => ['required', 'string', 'max:10'],
            'pharmacy_city' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'consent_1' => ['required', 'accepted'],
            'consent_2' => ['required', 'accepted'],
            'consent_3' => ['required', 'accepted'],
            'ref' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
            'phone' => $request->phone,
            'pwz_number' => $request->pwz_number,
            'pharmacy_address' => $request->pharmacy_address,
            'pharmacy_postal_code' => $request->pharmacy_postal_code,
            'pharmacy_city' => $request->pharmacy_city,
            'ref' => $request->ref,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
