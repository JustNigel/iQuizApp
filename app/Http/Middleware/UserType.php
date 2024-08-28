<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $type)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect('/')->with('error', 'Unauthorized access');
        }
    
        if ($user->type_name === $type) {
            
            return $next($request);
        }
    
        switch ($user->type_name) {
            case 'student':
                return redirect()->route('student.dashboard');
            case 'trainer':
                return redirect()->route('trainer.dashboard'); 
            case 'admin':
                return redirect()->route('admin.dashboard.dashboard'); 
            default:
                return redirect('/')->with('error', 'Unauthorized access');
        }
    }
    
}
