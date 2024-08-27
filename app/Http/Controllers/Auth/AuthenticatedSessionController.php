<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        $user = Auth::user();

        if ($user->type_name === 'student') {
            $requestStatus = DB::table('registration_requests')
                ->where('user_id', $user->id)
                ->value('request_status');
            if ($requestStatus === 'accepted') {
                return redirect()->intended(route('dashboard'));
            } else {
                return redirect()->route('auth.verify-registration');
            }
        } elseif ($user->type_name === 'admin') {
            return redirect()->intended(route('admin.dashboard.dashboard'));
        } elseif ($user->type_name === 'trainer') {
            return redirect()->intended(route('trainer.dashboard'));
        }

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showLoginForm()
{
    return view('auth.login'); 
}

}
