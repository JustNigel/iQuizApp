<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function displayAllRegistrationRequest()
    {
        $user = auth()->user();
        $requests = DB::table('registration_requests')
            ->join('users', 'registration_requests.user_id', '=', 'users.id')
            ->where('users.type_name', 'student')
            ->where('registration_requests.request_status', '!=', 'accepted') 
            ->select('users.name', 'users.username', 'users.email', 'registration_requests.id', 'registration_requests.request_status')
            ->get();
    
        return view('admin.all-registration-request', compact('requests', 'user'));
    }
    
    public function displayVerificationRegistration(){
        return view('admin.verify-registration');
    }
    
    public function checkStatus()
    {
        $user = auth()->user();
    
        // Replace `exam_user` with your pivot table name and adjust field names as needed
        $registration = DB::table('registration_request')
            ->where('user_id', $user->id)
            ->where('request_status', 'accepted')
            ->first();
    
        if ($registration) {
            return response()->json(['redirect' => route('student.dashboard')]);
        }
    
        return response()->json(['redirect' => null]);
    }
    
    

    
    public function acceptRequest($id)
    {
        DB::table('registration_requests')
            ->where('id', $id)
            ->update(['request_status' => 'accepted']);

        return redirect()->route('admin.all-registration-request')->with('status', 'Request accepted');
    }

    public function denyRequest($id)
    {
        DB::table('registration_requests')
            ->where('id', $id)
            ->update(['request_status' => 'denied']);

        return redirect()->route('admin.all-registration-request')->with('status', 'Request denied');
    }

}
