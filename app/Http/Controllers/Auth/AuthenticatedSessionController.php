<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        $url = 'dashboard';
        if(Auth::user()->role === 'admin'){
            $url = 'admin';
        }elseif(Auth::user()->role === 'editor'){
            $url = 'editor';
        }elseif(Auth::user()->role === 'author'){
            $url = 'author';
        }elseif(Auth::user()->role === 'reviewer'){
            $url = 'reviewer';
        }elseif(Auth::user()->role === 'editorial_assistant'){
            $url = 'editorial-assistant';
        }

        return redirect()->intended($url);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
