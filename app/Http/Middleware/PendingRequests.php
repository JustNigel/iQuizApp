<?php

namespace App\Http\Middleware;

use App\Models\ExamRequest;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PendingRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */ 
    public function handle(Request $request, Closure $next): Response
    {
        
        $pendingRequestsCount = ExamRequest::where('request_status', 'pending')->count();  
        $pendingRegistrationRequestsCount = DB::table('registration_requests')
            ->where('request_status', 'pending') 
            ->count();
    
        view()->share([
            'pendingRequestsCount' => $pendingRequestsCount,
            'pendingRegRequestsCount' => $pendingRegistrationRequestsCount,
        ]);
    
        return $next($request);
    }   
}
