<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function createCategory(){
        $user = auth()->user();
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
        $user = auth()->user();
        $categories = ExamCategory::with('trainers')
            ->get();
        return view('admin.all-category', compact('categories', 'user'));
    }
    

    public function editCategory($id){
        $user = auth()->user();
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
                'array', // Ensure trainer_id is an array for multiple selection
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
        $user = auth()->user();
        $categories = ExamCategory::whereHas('trainers', function ($query) use ($trainerId) {
        $query->where('users.id', $trainerId);
            })->get();
    
        return view('admin.all-category', compact('categories', 'user'));
    }

    public function showCategoryDeleteConfirmation($id){
        $user = auth()->user();
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

