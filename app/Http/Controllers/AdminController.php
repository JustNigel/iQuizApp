<?php

namespace App\Http\Controllers;

use App\Models\ConfirmedRegistration;
use App\Models\ExamCategory;
use App\Models\ExamRequest;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display the Admin dashboard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $pendingRequestsCount = ExamRequest::where('request_status', 'pending')->count();
        return view('admin.dashboard.dashboard', compact('user','pendingRequestsCount'));
    }

    public function addTrainer(){
        $user = Auth::user();
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

    public function editTrainerProfile($id)
    {
        $user = Auth::user();
        $trainer = User::where('id', $id)->where('type_name', 'trainer')->firstOrFail();
        
        // Pass both $trainer and $user to the view
        return view('admin.edit-trainer-profile', compact('trainer', 'user'));
    }
    
    
    
    
    public function updateTrainerProfile(Request $request, $id): RedirectResponse
    {
        $trainer = User::where('id', $id)->where('type_name', 'trainer')->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'age' => 'nullable|integer',
            'birthday' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'gender' => 'required|string|in:male,female',
            'email' => 'required|string|email|max:255|unique:users,email,' . $trainer->id,
        ]);

        $trainer->update($request->all());

        return redirect()->route('admin.edit-trainer-profile', $trainer->id)->with('status', 'Profile updated!');
    }

    public function updateTrainerPassword(Request $request, $id): RedirectResponse
    {
        $trainer = User::where('id', $id)->where('type_name', 'trainer')->firstOrFail();

        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|confirmed|min:8', // Changed 'new_password' to 'password' to match form
        ]);

        // Check if the current password is correct
        if (!Hash::check($request->current_password, $trainer->password)) {
            return back()->withErrors(['current_password' => 'The provided password does not match our records.']);
        }

        // Update the trainer's password
        $trainer->password = Hash::make($request->password);
        $trainer->save();

        return redirect()->route('admin.edit-trainer-profile', $trainer->id)->with('status', 'Password updated!');
    }

    public function deleteTrainerProfile($id){
        $trainer = User::where('id', $id)->where('type_name', 'trainer')->firstOrFail();
        $trainer->delete();
    
        return redirect()->route('admin.all-trainers')->with('status', 'Trainer deleted!');
    }

    public function displayAllStudents()
    {
        $user = Auth::user();
        $students = ConfirmedRegistration::getAllStudents(); 
        if ($user->type_name === 'trainer') {
            return view('trainer.all-students', compact('students', 'user'));
        } else {
            return view('admin.all-students', compact('students', 'user'));
        }
    }
    

    public function showStudentDeleteConfirmation($id)
    {
        $user = Auth::user();
        $student = User::findStudentById($id);
        return view('admin.confirm-delete-student', compact('user', 'student'));
    }
    
    
    public function deleteStudent(Request $request, $id){
        $student = User::where('id', $id)
                        ->where('type_name', 'student')
                        ->firstOrFail(); 
        $student->delete();
        return redirect()->route('admin.all-students')->with('success', 'Student deleted successfully!');
    }
    
    public function displayAddQuestionnaire($id)
    {
        $user = Auth::user();
        $questionnaire = Questionnaire::with('trainer', 'category')
            ->findOrFail($id);

        if ($user->type_name === 'admin') {
            $questions = Question::where('questionnaire_id', $id)->get();
        } else {
            $questions = Question::where('questionnaire_id', $id)
                ->whereHas('questionnaire', function($query) use ($user) {
                    $query->where('trainer_id', $user->id);
                })
                ->get();
        }

        return view('layouts.questionnaire', compact('user', 'questionnaire', 'questions'));
    }

    
    public function store(Request $request)
    {
        $rules = [
            'question_text' => 'required|string',
            'question_type' => 'required|string',
            'questionnaire_id' => 'nullable|exists:exam_questionnaires,id',
            'points' => 'required|integer|min:1',
            'options' => 'nullable|array',
            'options.*' => 'string',
            'descriptions' => 'nullable|array',
            'descriptions.*' => 'string',
            'files' => 'nullable|array', 
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    
        // Validate answer_key based on question type
        if ($request->input('question_type') === 'multiple-choice') {
            $rules['answer_key'] = 'nullable|string';
        } else {
            $rules['answer_key'] = 'nullable|array';
            $rules['answer_key.*'] = 'string';
        }
    
        $validatedData = $request->validate($rules);
    
        $question = new Question();
        $question->question_text = $validatedData['question_text'];
        $question->question_type = $validatedData['question_type'];
        $question->questionnaire_id = $validatedData['questionnaire_id'] ?? null;
        $question->points = $validatedData['points'];
    
        if ($request->hasFile('files')) {
            $uploadedFiles = [];
            foreach ($request->file('files') as $file) {
                // Save the file and store its path
                $path = $file->store('uploads', 'public'); // Store in the public disk
                $uploadedFiles[] = $path; // Add the path to the array
            }
            // Save the file paths as a JSON string
            $question->file_path = json_encode($uploadedFiles);
        }
    
        // Associate category if questionnaire_id exists
        if (!empty($validatedData['questionnaire_id'])) {
            $questionnaire = Questionnaire::find($validatedData['questionnaire_id']);
            $question->category_id = $questionnaire->category_id ?? null;
        }
    
        // Set options if present
        if (!empty($validatedData['options'])) {
            $question->options = json_encode($validatedData['options']);
        }
    
        // Handle answer_key, matching_key, and descriptions based on question_type
        switch ($request->input('question_type')) {
            case 'multiple-choice':
                $question->answer_key = $validatedData['answer_key'] ?? null;
                break;
    
            case 'checkboxes':
                $answerKey = $validatedData['answer_key'] ?? [];
                $question->answer_key = !empty($answerKey) ? implode(',', $answerKey) : null;
                break;
    
            case 'drag-drop':
                $options = $validatedData['options'] ?? [];
                $indices = array_keys($options);
                $question->answer_key = !empty($indices) ? implode(',', $indices) : null;
                break;
    
            case 'matching':
                // For matching questions, create the matching_key from descriptions and options
                $descriptions = $validatedData['descriptions'] ?? [];
                $options = $validatedData['options'] ?? [];
                $matchingKey = [];
    
                foreach ($descriptions as $index => $description) {
                    if (isset($options[$index])) {
                        $matchingKey[] = [
                            'description' => $description,
                            'option' => $options[$index],
                        ];
                    }
                }
    
                // Save the matching_key as a JSON-encoded string
                $question->matching_key = !empty($matchingKey) ? json_encode($matchingKey) : null;
    
                // Save the descriptions as a JSON-encoded string in the descriptions column
                $question->descriptions = !empty($descriptions) ? json_encode($descriptions) : null;
                break;
        }
    
        // Save the question
        $question->save();
    
        return redirect()->route('admin.questionnaire', ['id' => $validatedData['questionnaire_id']])
                        ->with('success', 'Question created successfully.');
    }
    

}   