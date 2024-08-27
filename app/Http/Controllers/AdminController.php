<?php

namespace App\Http\Controllers;

use App\Models\ExamCategory;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('admin.dashboard.dashboard', compact('user'));
    }

    public function trainerList(){
        $user = auth()->user();
        return view('admin.all-trainers', compact('user'));

    }

    public function addTrainer(){
        $user = auth()->user();
        return view('admin.add-trainer', compact('user'));
    }

    public function storeTrainer(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'type_name' => ['required', 'in:admin,trainer'] // Corrected value here
        ]);

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type_name' => $request->type_name, 
        ]);

        event(new Registered($user));


        return redirect()->route('admin.add-trainer')->with('success', 'Trainer registered successfully!');
    }

    public function editTrainerProfile($id)
    {
        $user = auth()->user(); 
        $trainer = User::where('id', $id)->where('type_name', 'trainer')->firstOrFail();
        
        // Pass both $trainer and $user to the view
        return view('admin.edit-trainer-profile', compact('trainer', 'user'));
    }
    
    
    
    
    public function updateTrainerProfile(Request $request, $id)
    {
        
        $trainer = User::where('id', $id)->where('type_name', 'trainer')->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'nullable|integer',
            'birthday' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'gender' => 'required|string|in:male,female',
            'email' => 'required|string|email|max:255|unique:users,email,' . $trainer->id,
        ]);

        $trainer->update($request->all());

        return redirect()->route('admin.edit-trainer-profile', $trainer->id)->with('status', 'Profile updated!');
    }
    public function updateTrainerPassword(Request $request, $id){
        $trainer = User::where('id', $id)->where('type_name', 'trainer')->firstOrFail();
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|confirmed|min:8',
        ]);
        if (Hash::check($request->current_password, $trainer->password)) {
            return back()->withErrors(['current_password' => 'The provided password does not match our records.']);
        }
        $trainer->password = Hash::make($request->new_password);
        $trainer->save();
        return redirect()->route('admin.edit-trainer-profile', $trainer->id)->with('status', 'Password updated!');
    }

    public function deleteTrainerProfile($id){
        $trainer = User::where('id', $id)->where('type_name', 'trainer')->firstOrFail();
        $trainer->delete();
    
        return redirect()->route('admin.all-trainers')->with('status', 'Trainer deleted!');
    }

    public function displayAllStudents()
    {
        $user = auth()->user();
        $student = DB::table('confirmed_registrations')
            ->join('users', 'confirmed_registrations.student_id', '=', 'users.id')
            ->where('users.type_name', 'student')
            ->select('users.name', 'users.last_name', 'users.username', 'users.email', 'confirmed_registrations.id', 'confirmed_registrations.request_status')
            ->get();
        
        return view('admin.all-students', compact('student', 'user'));
    }


    public function showStudentDeleteConfirmation($id){
        $user = auth()->user();
        $student = User::where('id', $id)
                        ->where('type_name', 'student')
                        ->firstOrFail(); 
    
        return view('admin.confirm-delete-student', compact('user', 'student'));
    }
    
    public function deleteStudent(Request $request, $id){
        $student = User::where('id', $id)
                        ->where('type_name', 'student')
                        ->firstOrFail(); 
        $student->delete();
        return redirect()->route('admin.all-students')->with('success', 'Student deleted successfully!');
    }
    
    
    
    
}
