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
        return view('auth.verify-registration');
    }
    
    public function checkIfAccepted(Request $request)
    {
        $user = $request->user();
        if ($user->request_status === 'accepted') {
            return redirect()->route('login');
        }
        return redirect()->route('auth.verify-registration')->with('status', 'Please wait for admin confirmation.');
    }
    
    public function acceptRequest($id)
    {
        // Find the registration request by ID
        $request = DB::table('registration_requests')->where('id', $id)->first();
    
        if ($request) {
            // Insert the accepted request into the confirmed_registrations table
            DB::table('confirmed_registrations')->insert([
                'student_id' => $request->user_id, // Assuming user_id is the student_id
                'request_status' => 'accepted',   // Setting the request status to 'accepted'
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            // Delete the original registration request
            DB::table('registration_requests')->where('id', $id)->delete();
    
            return redirect()->route('admin.all-registration-request')->with('status', 'Request accepted and student confirmed');
        }
    
        return redirect()->route('admin.all-registration-request')->with('status', 'Request not found');
    }
    


    public function denyRequest($id)
    {
        $request = DB::table('registration_requests')->where('id', $id)->first();
    
        if ($request) {
            DB::table('users')->where('id', $request->user_id)->delete();
            DB::table('registration_requests')->where('id', $id)->delete();
        }
    
        return redirect()->route('admin.all-registration-request')->with('status', 'User and request deleted successfully');
    }
    

}
