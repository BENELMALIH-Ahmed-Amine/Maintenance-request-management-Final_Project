<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {   
        $roles = Role::all();
        $categorys = Category::all();
        return view('auth.register', compact('roles', 'categorys'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'address' => ['required', 'string'],
            'profil' => ['nullable', 'image', 'max:2048'],
            'user_type' => 'required',
            'category_id' => 'nullable'
        ]);

        $path = $request->file('profil')->store('Profils', 'public');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'category_id' => $request->category_id,
            'profil' => $path,
        ]);

        $userRole = Role::find($request->user_type);
        $user->assignRole($userRole->name);

        event(new Registered($user));

        Auth::login($user);

        if ($user->hasRole('admin')) {
            return redirect(route('filterPosts', absolute: false));
        } else {
            return redirect(route('dashboard', absolute: false));
        }
    }
}
