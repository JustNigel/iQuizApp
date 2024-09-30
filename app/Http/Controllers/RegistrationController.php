<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function displayAllRegistrationRequest()
    {
        $user = Auth::user();
        $requests = DB::table('registration_requests')
            ->join('users', 'registration_requests.user_id', '=', 'users.id')
            ->where('users.type_name', 'student')
            ->where('registration_requests.request_status', '!=', 'accepted') 
            ->select('users.name', 'users.username', 'users.email', 'registration_requests.id', 'registration_requests.request_status')
            ->get();
        
        if ($user->type_name === 'trainer') {
            return view('trainer.all-registration-request', compact('requests', 'user'));
        } else {
            return view('admin.all-registration-request', compact('requests', 'user'));
        }
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
        $request = DB::table('registration_requests')->where('id', $id)->first();
        
        if ($request) {
            DB::table('confirmed_registrations')->insert([
                'student_id' => $request->user_id, 
                'request_status' => 'accepted',   
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    
            DB::table('registration_requests')->where('id', $id)->delete();
            
            if (Auth::user()->type_name === 'trainer') {
                return redirect()->route('trainer.all-registration-request')->with('status', 'Request accepted and student confirmed');
            } else {
                return redirect()->route('admin.all-registration-request')->with('status', 'Request accepted and student confirmed');
            }
        }
    
        if (Auth::user()->type_name === 'trainer') {
            return redirect()->route('trainer.all-registration-request')->with('status', 'Request not found');
        } else {
            return redirect()->route('admin.all-registration-request')->with('status', 'Request not found');
        }
    }
    


    public function denyRequest($id)
    {
        $request = DB::table('registration_requests')->where('id', $id)->first();
        
        if ($request) {
            DB::table('users')->where('id', $request->user_id)->delete();
            DB::table('registration_requests')->where('id', $id)->delete();
        }
        
        if (Auth::user()->type_name === 'trainer') {
            return redirect()->route('trainer.all-registration-request')->with('status', 'User and request deleted successfully');
        } else {
            return redirect()->route('admin.all-registration-request')->with('status', 'User and request deleted successfully');
        }
    }
    
    

}
