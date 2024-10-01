<?php

namespace App\Http\Controllers;

use App\Models\ExamCategory;
use App\Models\ExamRequest;
use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionnaireController extends Controller
{

    public function storeQuestionnaire(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'number_of_items' => 'required|integer',
            'time_interval' => 'required|integer',
            'passing_grade' => 'nullable|integer',
            'category_id' => 'required|exists:exam_categories,id',
            'trainer_id' => 'required|exists:users,id',
            'shuffle' => 'nullable|boolean',
        ]);
    
        // Check if a trainer is selected
        if (is_null($request->input('trainer_id'))) {
            return redirect()->back()->withInput()->with('error', 'You should choose a trainer.');
        }
    
        $questionnaire = new Questionnaire();
        $questionnaire->title = $request->input('title');
        $questionnaire->number_of_items = $request->input('number_of_items');
        $questionnaire->time_interval = $request->input('time_interval');
        $questionnaire->passing_grade = $request->input('passing_grade');
        $questionnaire->category_id = $request->input('category_id');
        $questionnaire->trainer_id = $request->input('trainer_id');
        $questionnaire->shuffle = $request->input('shuffle', false);
        $questionnaire->save();
    
        return redirect()->route('admin.all-questionnaire', ['categoryId' => $questionnaire->category_id])->with('success', 'Questionnaire created successfully!');
    }
    

    public function addQuestionnaire(){
        $user = Auth::user();
        $categories = ExamCategory::all(); 
        $trainers = User::where('type_name', 'trainer')->get(); 
    
        return view('admin.add-questionnaire', compact('user', 'categories', 'trainers'));
    }

    public function editQuestionnaire($id)
    {
        $user = Auth::user();
        $questionnaire = Questionnaire::findOrFail($id);
        $trainers = User::where('type_name', 'trainer')->get(); 
        $categories = ExamCategory::all(); // Fetch all categories


        if (Auth::user()->type_name === 'trainer') {
            return view('trainer.edit-questionnaire', compact('user', 'questionnaire', 'trainers', 'categories'));
        } else {
            return view('admin.edit-questionnaire', compact('user', 'questionnaire', 'trainers', 'categories'));
    
        }

    
    }
    
    public function updateQuestionnaire(Request $request, $id){
        $request->validate([
            'title' => 'required|string|max:255',
            'number_of_items' => 'required|integer',
            'time_interval' => 'required|integer',
            'passing_grade' => 'required|integer',
            'category_id' => 'required|exists:exam_categories,id',
            'trainer_id' => 'required|array',
            'trainer_id.*' => 'exists:users,id',
            'shuffle' => 'nullable|boolean',
        ]);

        $questionnaire = Questionnaire::findOrFail($id);
        $questionnaire->update([
            'title' => $request->input('title'),
            'number_of_items' => $request->input('number_of_items'),
            'time_interval' => $request->input('time_interval'),
            'passing_grade' => $request->input('passing_grade'),
            'category_id' => $request->input('category_id'),
            'shuffle' => $request->has('shuffle'),
        ]);
        $questionnaire->trainers()->sync($request->input('trainer_id'));

        return redirect()->route('admin.all-questionnaire', ['categoryId' => $request->input('category_id')])
                        ->with('success', 'Questionnaire updated successfully!');
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
        $user = Auth::user();
        $category = ExamCategory::findOrFail($categoryId); 
        $pendingRequestsCount = ExamRequest::where('request_status', 'pending')->count();
        $query = Questionnaire::where('category_id', $categoryId);

        if ($user->type_name === 'trainer') {
            $query->whereHas('trainers', function ($q) use ($user) {
                $q->where('trainer_id', $user->id);
            });
        } elseif ($trainerId) {
            $query->whereHas('trainers', function ($q) use ($trainerId) {
                $q->where('trainer_id', $trainerId);
            });
        }



        $questionnaires = $query->orderByRaw("CASE WHEN access_status = 'visible' THEN 0 ELSE 1 END")->get();

        if (Auth::user()->type_name === 'trainer') {
            return view('trainer.all-questionnaire', compact('questionnaires', 'user', 'category','pendingRequestsCount'));
         } else {
            return view('admin.all-questionnaire', compact('questionnaires', 'user', 'category','pendingRequestsCount'));
        
        }
    }

    
    public function displayListQuestionnaires() {
        $user = Auth::user();
        session(['previous_page' => 'all-questionnaires']);

        if ($user->type_name === 'trainer') {
            $questionnaires = Questionnaire::where('trainer_id', $user->id)
                ->orderByRaw('access_status = "visible" DESC')
                ->paginate(10);
        } else {
            $questionnaires = Questionnaire::orderByRaw('access_status = "visible" DESC')->paginate(10);
        }
    

        if (Auth::user()->type_name === 'trainer') {
            return view('trainer.all-questionnaires', compact('questionnaires', 'user'));
        } else {
            return view('admin.all-questionnaires', compact('questionnaires', 'user')); }


    
    }
    
    
    


    
    public function addAnotherQuestionnaire($categoryId){
        $user = Auth::user();
        $categories = ExamCategory::all(); // Fetch all categories
        $trainers = User::where('type_name', 'trainer')->get(); // Fetch trainers
        $selectedCategory = ExamCategory::findOrFail($categoryId); // Fetch the selected category
    
        return view('admin.add-another-questionnaire', compact('user', 'categories', 'trainers', 'selectedCategory'));
    }

    public function displayConfirmAddQuestionnairePrompt(Request $request) {
        $user = Auth::user();
        $data = $request->all();  // Get all form data
        
        return view('admin.confirm-add-questionnaire', compact('data', 'user'));
    }
    

    public function showQuestionnaireDeleteConfirmation($id){
        $user = Auth::user();
        $questionnaire = Questionnaire::findOrFail($id);
        return view('admin.confirm-delete-questionnaire', compact('questionnaire', 'user'));
    }

    public function deleteQuestionnaire($id){
        $questionnaire = Questionnaire::findOrFail($id);
        $categoryId = $questionnaire->category_id;
        $questionnaire->delete();
    
        return redirect()->route('admin.all-questionnaire', ['categoryId' => $categoryId])
                        ->with('success', 'Questionnaire deleted successfully!');
    }
    public function cancelAddQuestionnaire(Request $request)
    {
        return redirect()->route('admin.add-questionnaire')->with('error', 'Adding Questionnaire has been cancelled.');
    }

    public function toggleVisibility($id)
    {
        $questionnaire = Questionnaire::findOrFail($id);
        if ($questionnaire->access_status === 'hidden') {
            Questionnaire::where('trainer_id', $questionnaire->trainer_id)
                ->where('category_id', $questionnaire->category_id)
                ->update(['access_status' => 'hidden']);
            $questionnaire->access_status = 'visible';
        } else {
            $questionnaire->access_status = 'hidden';
        }
        $questionnaire->save();
        return redirect()->back()->with('status', 'Questionnaire visibility updated!');
    }

    
    
    


    
}
