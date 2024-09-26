<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamCategory;
use App\Models\ExamRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function createCategory(Request $request){
        $user = Auth::user();
        $previousPage = $request->input('from', 'dashboard'); // Default to dashboard if not specified
        session(['previous_page' => $previousPage]);

        $trainers = User::where('type_name', 'trainer')
            ->get(); 
            
        return view('admin.add-category', compact('user', 'trainers'));
    }

    public function storeCategory(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'required|string',
            'trainer_id' => ['required','array',],
            'trainer_id.*' => ['exists:users,id',
                function ($attribute, $value, $fail) {
                    if (!User::where('id', $value)
                        ->where('type_name', 'trainer')
                        ->exists()) {
                        $fail('The selected trainer is invalid.');
                    }
                },
            ],
        ]);
        $category = ExamCategory::create([
            'title' => $request->title,
            'description' => $request->details,
        ]);
        foreach ($request->trainer_id as $trainerId) {
            $trainer = User::findOrFail($trainerId);
            $trainer->examCategories()
                    ->attach($category->id);
        }

        return redirect()->route('admin.all-category')->with('success', 'Exam category created successfully!');
    }

    public function allCategories(){
        $user = Auth::user();
        $categories = ExamCategory::with('trainers')->paginate(10);
        return view('admin.all-category', compact('categories', 'user'));
    }
    

    public function editCategory($id){
        $user = Auth::user();
        $category = ExamCategory::with('trainers')->findOrFail($id);
        $trainers = User::where('type_name', 'trainer')->get(); 
        return view('admin.edit', compact('category', 'trainers', 'user'));
    }
    
    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'trainer_id' => [
                'required',
                'array', 
            ],
            'trainer_id.*' => [
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    if (!User::where('id', $value)->where('type_name', 'trainer')->exists()) {
                        $fail('The selected trainer is invalid.');
                    }
                },
            ],
        ]);
    
        $category = ExamCategory::findOrFail($id);
        $category->update([ 'title' => $request->title,
                            'description' => $request->description]);
        $category->trainers()->detach();
        foreach ($request->trainer_id as $trainerId) {
            $trainer = User::findOrFail($trainerId);
            $trainer->examCategories()->attach($category->id);
        }
    
        return redirect()->route('admin.all-category')->with('success', 'Category updated successfully!');
        
    }
    
    public function filterByTrainer($trainerId){
        $user = Auth::user();
        $categories = ExamCategory::whereHas('trainers', function ($query) use ($trainerId) {
            $query->where('users.id', $trainerId);
        })->paginate(10);
        
        return view('admin.all-category', compact('categories', 'user'));
    }
    

    public function showCategoryDeleteConfirmation($id){
        $user = Auth::user();
        $category = ExamCategory::findOrFail($id);

        return view('admin.confirm-delete', compact('category','user'));
        
    }

    public function deleteCategory(Request $request, $id){
        $category = ExamCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.all-category')->with('success', 'Category deleted successfully!');
    }

    public function cancelDeleteCategory(Request $request)
    {
        return redirect()->route('admin.all-category')->with('error', 'Delete Category has been cancelled.');
    }

    
}

