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
        $trainers = User::where('type_name', 'trainer')->get(); 
        return view('admin.add-category', compact('user', 'trainers'));
    }

    /**
     * Summary of storeCategory
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'required|string',
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

        // Store the new exam category
        $category = ExamCategory::create([
            'title' => $request->title,
            'description' => $request->details,
        ]);

        // Attach the selected trainers to the category using the pivot table
        foreach ($request->trainer_id as $trainerId) {
            $trainer = User::findOrFail($trainerId);
            $trainer->examCategories()->attach($category->id);
        }

        return redirect()->route('admin.all-category')->with('success', 'Exam category created successfully!');
    }


    /**
     * Summary of allCategories
     * @return \Illuminate\Contracts\View\View
     */
    public function allCategories()
    {
        $categories = ExamCategory::with('trainers')->get();
        $user = auth()->user();
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
        $category->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);
    
        // Detach existing trainers
        $category->trainers()->detach();
    
        // Attach new trainers
        foreach ($request->trainer_id as $trainerId) {
            $trainer = User::findOrFail($trainerId);
            $trainer->examCategories()->attach($category->id);
        }
    
        return redirect()->route('admin.all-category')->with('success', 'Category updated successfully!');
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
    

}

