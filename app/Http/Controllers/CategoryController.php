<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Exam;
use App\Models\ExamCategory;
use App\Models\ExamRequest;
use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display the form for creating a new exam category.
     *
     * This method retrieves the currently authenticated user and a list of all trainers
     * from the database, which are then passed to the view for rendering the category 
     * creation form.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function createCategory(Request $request){
        $user = Auth::user();
        $trainers = User::where('type_name', 'trainer')->get(); 
            
        return view('admin.add-category', compact('user', 'trainers'));
    }


    /**
     * Store a newly created exam category in the database.
     *
     * This method accepts a validated request containing the category's title, description, 
     * and associated trainer IDs. It creates a new category record and associates the 
     * selected trainers with the category using a many-to-many relationship.
     *
     * @param \App\Http\Requests\CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeCategory(CategoryRequest $request){
        $category = ExamCategory::create([
            'title' => $request->title,
            'description' => $request->details,
        ]);
        $category->trainers()->sync($request->trainer_id);

        return redirect()->route('admin.all-category')->with('success', 'Exam category created successfully!');
    }


    /**
     * Retrieve and display all exam categories with their associated trainers.
     *
     * This method fetches a paginated list of all exam categories, including the
     * related trainers for each category. It also retrieves the currently authenticated
     * user to pass to the view. The results are then rendered in the 'admin.all-category'
     * view for display.
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function allCategories(){
        $user = Auth::user();
        $categories = ExamCategory::with('trainers')->paginate(10);
        return view('admin.all-category', compact('categories', 'user'));
    }
    

    /**
     * Show the form for editing the specified exam category.
     *
     * This method retrieves the specified exam category, along with its associated
     * trainers, using the provided category ID. It also fetches the currently
     * authenticated user. The data is then passed to the 'admin.edit' view, where
     * the category can be edited.
     * 
     * @param mixed $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function editCategory($id){
        $user = Auth::user();
        $category = ExamCategory::with('trainers')->findOrFail($id);
        $trainers = User::where('type_name', 'trainer')->get(); 
        return view('admin.edit', compact('category', 'trainers', 'user'));
    }
    

    /**
     * Update the specified exam category in storage.
     *
     * This method handles the updating of an existing exam category based on the 
     * provided ID. It updates the category's title and description using the 
     * validated data from the CategoryRequest. The method also syncs the selected 
     * trainers to the category, ensuring that the associated trainers are updated 
     * accordingly. After updating, the user is redirected back to the 
     * 'admin.all-category' route with a success message.
     * 
     * @param \App\Http\Requests\CategoryRequest $request
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCategory(CategoryRequest $request, $id){
        $category = ExamCategory::findOrFail($id);
        $category->update([
            'title' => $request->title,
            'description' => $request->details,]);
        $category->trainers()->sync($request->trainer_id);
        return redirect()->route('admin.all-category')->with('success', 'Category updated successfully!');
    }
    

    /**
     * Filter exam categories by trainer.
     *
     * This method filters the exam categories to only show those associated with a specific 
     * trainer, identified by the provided trainer ID. It uses a query to filter categories 
     * where the specified trainer is associated via the trainers relationship. The filtered 
     * categories are paginated and passed to the 'admin.all-category' view along with the 
     * authenticated user information.
     * 
     * @param mixed $trainerId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function filterByTrainer($trainerId){
        $user = Auth::user();
        $categories = ExamCategory::whereHas('trainers', function ($query) use ($trainerId) {
            $query->where('users.id', $trainerId);
        })->paginate(10);
        
        return view('admin.all-category', compact('categories', 'user'));
    }
    

    /**
     * Display the category delete confirmation page.
     *
     * This method retrieves the exam category by its ID and loads the delete confirmation view. 
     * The view allows the user to confirm or cancel the deletion of the specified category. 
     * The authenticated user and the category data are passed to the view.
     * 
     * @param mixed $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showCategoryDeleteConfirmation($id){
        $user = Auth::user();
        $category = ExamCategory::findOrFail($id);

        return view('admin.confirm-delete', compact('category','user'));
        
    }


    /**
     * Delete the specified exam category.
     *
     * This method deletes the exam category identified by the given ID from the database.
     * After deletion, the user is redirected to the list of all categories with a success message.
     *
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteCategory($id){
        $category = ExamCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.all-category')->with('success', 'Category deleted successfully!');
    }


    /**
     * Cancel the category deletion process.
     *
     * This method redirects the user back to the all-categories page with a message indicating that the
     * category deletion has been canceled.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelDeleteCategory(){
        return redirect()->route('admin.all-category')->with('error', 'Delete Category has been cancelled.');
    }

    
    /**
     * Summary of displayAllQuestionnaire
     * 
     * The filtering of existing questionnaires is based on
     * the category_id while optionally for trainer_id
     * 
     * @param mixed $categoryId
     * @param mixed $trainerId
     * @return \Illuminate\Contracts\View\View
     */
    public function displayAllQuestionnaire($categoryId, $trainerId = null)
    {
        $user = Auth::user();
        $category = ExamCategory::findOrFail($categoryId);
        $pendingRequestsCount = ExamRequest::where('request_status', 'pending')->count();
        $questionnaires = Questionnaire::getAllByCategoryAndTrainer($categoryId, $user, $trainerId);
        return view($user->type_name === 'trainer' ? 'trainer.all-questionnaire' : 'admin.all-questionnaire', 
            compact('questionnaires', 'user', 'category', 'pendingRequestsCount'));
    }
    
}

