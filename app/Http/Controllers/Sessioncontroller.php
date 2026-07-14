<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class SessionController extends Controller
{


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("auth.login");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            return match ($user->role) {
                'super_admin' => redirect('/super'),
                'admin' => redirect('/dashboard'),
                default => abort(403),
            };
        }
        return back()
            ->withErrors([
                'email' => 'Identifiants incorrects',
            ])
            ->onlyInput('email');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
