<?php

namespace App\Http\Controllers;

use App\Models\ExamCategory;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Http\RedirectResponse;
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

    // public function allCategories()
    // {
    //     // Fetch all categories
    //     $categories = ExamCategory::all();

    //     $user = auth()->user();
    //     // Pass categories to the view
    //     return view('admin.all-category', compact('categories','user'));
    // }
    

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

    public function showCategoryDeleteConfirmation($id)
    {
        $user = auth()->user();
        $category = ExamCategory::findOrFail($id);
        return view('admin.confirm-delete', compact('category','user'));
    }

    public function deleteCategory(Request $request, $id)
    {
        $category = ExamCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.all-category')->with('success', 'Category deleted successfully!');
    }
    
}
