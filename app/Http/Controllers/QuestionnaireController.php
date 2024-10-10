<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionnaireRequest;
use App\Models\ExamCategory;
use App\Models\ExamRequest;
use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionnaireController extends Controller
{

    /**
     * 
     * Stores the Questionnaire Data
     * @param \App\Http\Requests\StoreQuestionnaireRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeQuestionnaire(StoreQuestionnaireRequest $request)
    {
        $request->validateTrainerId();
        Questionnaire::createFromRequest($request->all());
    
        return redirect()->route('admin.all-questionnaire', ['categoryId' => $request->input('category_id')])
            ->with('success', 'Questionnaire created successfully!');
    }
    

    /**
     * 
     * Displays the Add Questionnaire Page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function addQuestionnaire(){
        $user = Auth::user();
        $categories = ExamCategory::all(); 
        $trainers = User::where('type_name', 'trainer')->get(); 

        return view('admin.add-questionnaire', compact('user', 'categories', 'trainers'));
    }


    /**
     * 
     * Displays the Edit Questionnaire Page
     * @param mixed $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function editQuestionnaire($id)
    {
        $user = Auth::user();
        $questionnaire = Questionnaire::findOrFail($id);
        $trainers = User::where('type_name', 'trainer')->get(); 
        $categories = ExamCategory::all(); 

        return view($user->type_name === 'trainer' ? 'trainer.edit-questionnaire' : 'admin.edit-questionnaire', 
        compact('user', 'questionnaire', 'trainers', 'categories'));
    }
    

    /**
     * 
     * Updates the questionnaire data from the Edit Questionnaire Page
     * @param \App\Http\Requests\StoreQuestionnaireRequest $request
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateQuestionnaire(StoreQuestionnaireRequest $request, $id)
    {
        $questionnaire = Questionnaire::findOrFail($id);
        $questionnaire->update($request->except('trainer_id'));
        $questionnaire->trainers()->sync($request->input('trainer_id'));

        return redirect()->route('admin.all-questionnaire', ['categoryId' => $request->input('category_id')])
                        ->with('success', 'Questionnaire updated successfully!');
    }


    /**
     * 
     * 
     * Displays all the questionnaires associated with category and Trainer ID
     * @param mixed $categoryId
     * @param mixed $trainerId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function displayAllQuestionnaire($categoryId, $trainerId = null)
    {
        $user = Auth::user();
        $questionnaireModel = new Questionnaire();
        $category = ExamCategory::findOrFail($categoryId); 
        $pendingRequestsCount = ExamRequest::where('request_status', 'pending')->count();
        $questionnaires = $questionnaireModel->getQuestionnairesByCategoryAndTrainer($categoryId, $trainerId);

        return view($user->type_name === 'trainer' ? 'trainer.all-questionnaire' : 'admin.all-questionnaire', 
        compact('questionnaires', 'user', 'category', 'pendingRequestsCount'));
    }
    

    /**
     * 
     * Displays the general list of questionnaires from all of the trainers and categories
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function displayListQuestionnaires()
    {
        $user = Auth::user();
        $questionnaireModel = new Questionnaire();
        if ($user->type_name === 'trainer') {
            $questionnaires = $questionnaireModel->getQuestionnairesByTrainer($user->id);
        } else {
            $questionnaires = $questionnaireModel->getQuestionnairesByTrainer();
        }

        return view($user->type_name === 'trainer' ? 'trainer.all-questionnaires' : 'admin.all-questionnaires', 
        compact('questionnaires', 'user'));
    }

    
    public function addAnotherQuestionnaire($categoryId){
        $user = Auth::user();
        $categories = ExamCategory::all(); // Fetch all categories
        $trainers = User::where('type_name', 'trainer')->get(); // Fetch trainers
        $selectedCategory = ExamCategory::findOrFail($categoryId); // Fetch the selected category
    
        return view('admin.add-another-questionnaire', compact('user', 'categories', 'trainers', 'selectedCategory'));
    }

    public function confirmAddPrompt(Request $request) {
        $user = Auth::user();
        $data = $request->all();
        
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
    public function cancelAddQuestionnaire()
    {
        return redirect()->route('admin.add-questionnaire')->with('error', 'Adding Questionnaire has been cancelled.');
    }

    public function toggleVisibility($id)
    {
        $questionnaire = Questionnaire::findOrFail($id);
        $questionnaire = $questionnaire->toggleVisibility();

        return redirect()->back()->with('status', 'Questionnaire visibility updated!');
    }
}
