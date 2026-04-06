<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if (!$user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()
                    ->route('login')
                    ->withErrors(['email' => 'This account has been deactivated.'])
                    ->withInput($request->only('email'));
            }

            $request->session()->regenerate();

            if ($user->isOwner()) {
                return redirect()->route('owner.dashboard');
            }

            return redirect()->route('staff.dashboard');
        }

        return redirect()
            ->route('login')
            ->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])
            ->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
