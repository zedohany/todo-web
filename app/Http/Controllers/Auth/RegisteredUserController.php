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
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Priority;
use App\Models\Category;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Priority::create(['name' => 'Low', 'color' => '#00FF00', 'user_id' => $user->id]);
        Priority::create(['name' => 'Medium', 'color' => '#FFA500', 'user_id' => $user->id]);
        Priority::create(['name' => 'High', 'color' => '#FF0000', 'user_id' => $user->id]);


        Category::create(['name' => 'Personal', 'user_id' => $user->id]);
        Category::create(['name' => 'Work', 'user_id' => $user->id]);
        Category::create(['name' => 'School', 'user_id' => $user->id]);

        event(new Registered($user));

        Auth::login($user);

        return to_route('dashboard');
    }
}
