<?php

namespace App\Http\Controllers;

use App\Models\ExamCategory;
use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainerController extends Controller
{
    public function index(){
        $user = auth()->user();
        return view('trainer.dashboard', compact('user'));
    }

    public function displayAllCategory(){
        $user = auth()->user();
        $categories = $user->examCategories()->get();
    
        return view('trainer.all-category', compact('categories', 'user'));
    }
    
    public function addQuestionnaire()
    {
        $user = auth()->user();
        $trainer = $user;
        $categories = ExamCategory::whereHas('trainers', function($query) use ($trainer) {
            $query->where('trainer_id', $trainer->id);
        })->get();
    
        return view('trainer.add-questionnaire', [
            'categories' => $categories,
            'user' => $user,
            'trainer' => $trainer,
        ]);
    }
    
    
    public function storeQuestionnaire(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'number_of_items' => 'required|integer',
            'time_interval' => 'required|integer',
            'passing_grade' => 'nullable|integer',
            'category_id' => 'required|exists:exam_categories,id',
            'trainer_id' => 'nullable|exists:users,id',
            'shuffle' => 'nullable|boolean',
        ]);
    
        $trainer = Auth::user();
    
        if ($trainer->type_name !== 'trainer') {
            return redirect()->route('trainer.dashboard')->with('error', 'Unauthorized access.');
        }
    
        $questionnaire = new Questionnaire();
        $questionnaire->title = $request->input('title');
        $questionnaire->number_of_items = $request->input('number_of_items');
        $questionnaire->time_interval = $request->input('time_interval');
        $questionnaire->passing_grade = $request->input('passing_grade');
        $questionnaire->category_id = $request->input('category_id');
        $questionnaire->trainer_id = $trainer->id; // Set the trainer ID from the logged-in trainer
        $questionnaire->shuffle = $request->input('shuffle', false);
        $questionnaire->save();
    
        return redirect()->route('trainer.add-questionnaire')->with('success', 'Questionnaire created successfully!');
    }
    
    public function showAllQuestionnaireDeleteConfirmation($categoryId)
    {
        $user = Auth::user();
        $category = ExamCategory::findOrFail($categoryId);
        return view('trainer.confirm-delete', compact('category', 'user'));
    }
    
    
    
    public function deleteAllQuestionnaire(Request $request, $categoryId)
    {
        // Find the category to ensure it exists
        $category = ExamCategory::findOrFail($categoryId);
    
        // Delete all questionnaires associated with this category
        $questionnaires = $category->questionnaires; // Adjust this if your relationship is different
    
        foreach ($questionnaires as $questionnaire) {
            $questionnaire->delete();
        }
    
        // Optionally, you can also delete the category itself
        // $category->delete();
    
        return redirect()->route('trainer.all-category')->with('success', 'All questionnaires have been deleted.');
    }
    
    
    
    
    


}
