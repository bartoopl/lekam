<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Representative;
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
            'pwz_number' => ['required_if:user_type,farmaceuta', 'nullable', 'string', 'max:20'],
            'pharmacy_address' => ['required', 'string', 'max:500'],
            'pharmacy_postal_code' => ['required', 'string', 'max:10'],
            'pharmacy_city' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'consent_1' => ['required'],
            'consent_2' => ['nullable'],
            'consent_3' => ['nullable'],
            'ref' => ['nullable', 'string', 'max:255'],
        ], [
            'consent_1.required' => 'Musisz zaakceptować obowiązkową zgodę dotyczącą przetwarzania danych osobowych.',
        ]);

        // Check if the ref parameter is a representative code
        $representative = null;
        if ($request->ref) {
            $representative = Representative::where('code', $request->ref)
                ->where('is_active', true)
                ->first();
        }

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
            'representative_id' => $representative ? $representative->id : null,
            'consent_1' => $request->has('consent_1'),
            'consent_2' => $request->has('consent_2'),
            'consent_3' => $request->has('consent_3'),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
