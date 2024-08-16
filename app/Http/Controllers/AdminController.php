<?php

namespace App\Http\Controllers;

use App\Models\ExamCategory;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('admin.dashboard.dashboard', compact('user'));
    }

    // public function addCategory()
    // {
    //     $user = auth()->user();
    //     return view('admin.add-category', compact('user'));
    // }

    public function create()
    {
        // Get the authenticated user
        $user = auth()->user();
    
        // Fetch all trainers from the users table where type_name is 'trainer'
        $trainers = User::where('type_name', 'trainer')->get(); 
    
        // Pass both user and trainers to the view
        return view('admin.add-category', compact('user', 'trainers'));
    }
    

    public function storeCategory(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'required|string',
            'trainer_id' => [
                'required',
                'exists:users,id', // Ensure that the selected trainer exists in the users table
                function ($attribute, $value, $fail) {
                    if (!User::where('id', $value)->where('type_name', 'trainer')->exists()) {
                        $fail('The selected trainer is invalid.');
                    }
                },
            ],
        ]);

        // Store the new exam category
        ExamCategory::create([
            'title' => $request->title,
            'description' => $request->details,
            'trainer_id' => $request->trainer_id,
        ]);

        // Redirect to some page with a success message
        return redirect()->route('admin.all-category')->with('success', 'Exam category created successfully!');
    }
    
    public function allCategories()
    {
        // Fetch all categories
        $categories = ExamCategory::all();

        $user = auth()->user();
        // Pass categories to the view
        return view('admin.all-category', compact('categories','user'));
    }
    

}
