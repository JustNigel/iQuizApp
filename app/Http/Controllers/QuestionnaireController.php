<?php

namespace App\Http\Controllers;

use App\Models\ExamCategory;
use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{

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

        $questionnaire = new Questionnaire();
        $questionnaire->title = $request->input('title');
        $questionnaire->number_of_items = $request->input('number_of_items');
        $questionnaire->time_interval = $request->input('time_interval');
        $questionnaire->passing_grade = $request->input('passing_grade');
        $questionnaire->category_id = $request->input('category_id');
        $questionnaire->trainer_id = $request->input('trainer_id');
        $questionnaire->shuffle = $request->input('shuffle', false);
        $questionnaire->save();

        return redirect()->route('admin.add-questionnaire')->with('success', 'Questionnaire created successfully!');
    }

    public function addQuestionnaire(){
        $user = auth()->user();
        $categories = ExamCategory::all(); // Fetch all categories
    
        $trainers = User::where('type_name', 'trainer')->get(); // Fetch trainers
    
        return view('admin.add-questionnaire', compact('user', 'categories', 'trainers'));
    }
    
    /**
     * Summary of displayAllQuestionnaire
     * 
     * The filtering of existing questionnaires is based on
     * the category_id while optionally for trainer_id
     * @param mixed $categoryId
     * @param mixed $trainerId
     * @return \Illuminate\Contracts\View\View
     */
    public function displayAllQuestionnaire($categoryId, $trainerId = null)
    {
        $user = auth()->user();
        $category = ExamCategory::findOrFail($categoryId); // Fetch the selected category
        $query = Questionnaire::where('category_id', $categoryId);
        
        if ($trainerId) {
            $query->where('trainer_id', $trainerId);
        }
        
        $questionnaires = $query->get();
    
        // Pass the category to the view
        return view('admin.all-questionnaire', compact('questionnaires', 'user', 'category'));
    }
    
    public function addAnotherQuestionnaire($categoryId)
    {
        $user = auth()->user();
        $categories = ExamCategory::all(); // Fetch all categories
        $trainers = User::where('type_name', 'trainer')->get(); // Fetch trainers
        $selectedCategory = ExamCategory::findOrFail($categoryId); // Fetch the selected category
    
        return view('admin.add-another-questionnaire', compact('user', 'categories', 'trainers', 'selectedCategory'));
    }
    
    


    
}
