<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Log;

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

        // return redirect()->intended(route('app', absolute: false));
        $user = Auth::user();
        
        // Membuat token Sanctum untuk user
        $token = $user->createToken('YourAppName')->plainTextToken;

        // Menyimpan token dalam session atau cookie
        $request->session()->put('sanctum_token', $token);
        Session::put('locale', $user->language);

        // Mengarahkan pengguna ke halaman yang diinginkan setelah login
        return redirect()->intended(route('app', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $locale = $request->session()->get('locale');
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        $request->session()->put('locale', $locale);

        return redirect('/');
    }
}
