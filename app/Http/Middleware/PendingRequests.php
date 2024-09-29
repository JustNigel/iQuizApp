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
        // Fetch pending exam requests with student names and questionnaire details
        $pendingExamRequests = ExamRequest::with(['student', 'questionnaire'])
            ->where('request_status', 'pending')
            ->get(['student_id', 'questionnaire_id', 'created_at']); 

        // Fetch pending registration requests with student names and creation dates
        $pendingRegistrationRequests = DB::table('registration_requests')
            ->join('users', 'registration_requests.user_id', '=', 'users.id')
            ->where('registration_requests.request_status', 'pending')
            ->select('users.name as student_name', 'registration_requests.created_at')
            ->get();

        // Share the data with all views
        view()->share([
            'pendingExamRequests' => $pendingExamRequests,
            'pendingRegistrationRequests' => $pendingRegistrationRequests, // Change the name here
        ]);

        return $next($request);
    }
}
