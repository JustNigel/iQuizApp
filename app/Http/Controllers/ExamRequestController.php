<?php

namespace App\Http\Controllers;

use App\Models\ExamCategory;
use App\Models\ExamRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExamRequestController extends Controller
{
    public function requestJoin(Request $request)
    {
        $user = Auth::user();
        $query = $request->input('query');

        $categories = ExamCategory::query()
            ->whereHas('questionnaires', function($query) {
                $query->where('access_status', 'visible');
            })
            ->with(['trainers', 'questionnaires' => function($query) {
                $query->where('access_status', 'visible');
            }])
            ->when($query, function($queryBuilder) use ($query) {
                $queryBuilder->where('title', 'like', "%$query%")
                            ->orWhere('description', 'like', "%$query%");
            })
            ->get();

        $cards = $categories->flatMap(function($category) use ($user) {
            $questionnaires = $category->questionnaires;
            $trainers = $category->trainers;

            return $questionnaires->map(function($questionnaire) use ($category, $trainers, $user) {
                return $trainers->map(function($trainer) use ($category, $questionnaire, $user) {
                    $existingRequest = ExamRequest::where('student_id', $user->id)
                        ->where('category_id', $category->id)
                        ->where('trainer_id', $trainer->id)
                        ->where('questionnaire_id', $questionnaire->id)
                        ->first();

                    $confirmedRequest = DB::table('confirmed_exam_requests')
                        ->where('student_id', $user->id)
                        ->where('category_id', $category->id)
                        ->where('trainer_id', $trainer->id)
                        ->where('questionnaire_id', $questionnaire->id)
                        ->first();

                    $trainerName = $trainer->name;

                    return (object) [
                        'title' => $category->title,
                        'description' => $category->description,
                        'questionnaireTitle' => $questionnaire->title,
                        'questionnaireTimeInterval' => $questionnaire->time_interval,
                        'questionnairePassingGrade' => $questionnaire->passing_grade,
                        'trainerName' => $trainerName,
                        'categoryId' => $category->id,
                        'trainerId' => $trainer->id,
                        'questionnaireId' => $questionnaire->id,
                        'requestStatus' => $confirmedRequest ? 'accepted' : ($existingRequest ? $existingRequest->request_status : null),
                        'requestId' => $existingRequest ? $existingRequest->id : null,
                    ];
                });
            })->flatten();
        });

        if ($request->ajax()) {
            return view('category._cards', compact('cards'))->render();
        }

        return view('category.join', compact('user', 'cards'));
    }
    public function storeRequest(Request $request){
        $user = Auth::user();
        $categoryId = $request->input('category_id');
        $trainerId = $request->input('trainer_id');
        $questionnaireId = $request->input('questionnaire_id'); 

        if (!$trainerId) {
            return redirect()->route('category.join')->with('error', 'Unable to find a trainer for this category.');
        }

        if ($questionnaireId === null) {
            return redirect()->route('category.join')->with('error', 'No visible questionnaire found for this category.');
        }

        ExamRequest::create([
            'student_id' => $user->id,
            'category_id' => $categoryId,
            'trainer_id' => $trainerId,
            'questionnaire_id' => $questionnaireId, // Add questionnaire_id
            'request_status' => 'pending',
        ]);

        return redirect()->route('category.join')->with('success', 'Your request to join the exam has been sent.');
    }

    public function cancelRequest($id){
        $examRequest = ExamRequest::where('id', $id)
            ->where('request_status', 'pending')
            ->firstOrFail();
        $examRequest->delete();

        return redirect()->route('category.join')->with('success', 'Your request to join the exam has been sent.');
    }

    public function displayAllExamRequest(){
        $user = Auth::user();
        $exam_requests = DB::table('exam_requests')
            ->join('users', 'exam_requests.student_id', '=', 'users.id')
            ->join('exam_categories', 'exam_requests.category_id', '=', 'exam_categories.id')
            ->join('exam_questionnaires', 'exam_requests.questionnaire_id', '=', 'exam_questionnaires.id')
            ->where('users.type_name', 'student')
            ->where('exam_requests.request_status', '!=', 'accepted') 
            ->select('users.name', 'users.last_name', 'exam_questionnaires.title as questionnaire_title', 'exam_categories.title', 'exam_requests.id', 'exam_requests.request_status')
            ->get();
    
        return view('admin.all-exam-requests', compact('exam_requests', 'user'));
    }
    
    public function acceptExamRequest($id)
    {
        $examRequest = ExamRequest::where('id', $id)
            ->where('request_status', 'pending')
            ->firstOrFail();

        DB::table('confirmed_exam_requests')->insert([
            'student_id' => $examRequest->student_id,
            'category_id' => $examRequest->category_id,
            'trainer_id' => $examRequest->trainer_id,
            'questionnaire_id' => $examRequest->questionnaire_id,
            'request_status' => 'accepted',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $examRequest->delete();

        return redirect()->route('admin.all-exam-request')->with('success', 'Request has been accepted and moved to confirmed requests.');
    }
    


    public function displayAllAccepted(){
        $user = Auth::user();
        $confirmedStudents = DB::table('confirmed_exam_requests')
            ->join('users', 'confirmed_exam_requests.student_id', '=', 'users.id')
            ->join('exam_categories', 'confirmed_exam_requests.category_id', '=', 'exam_categories.id')
            ->join('exam_questionnaires', 'confirmed_exam_requests.questionnaire_id', '=', 'exam_questionnaires.id')
            ->select('users.name', 'users.last_name', 'exam_questionnaires.title as questionnaire_title', 'exam_categories.title', 'confirmed_exam_requests.request_status', 'confirmed_exam_requests.id')
            ->get();
    
        return view('admin.all-confirmed-students', compact('confirmedStudents', 'user'));
    }
    

    public function denyExamRequest($id)
    {
        $request = ExamRequest::findOrFail($id);
        $request->delete();
    
        return redirect()->route('admin.all-exam-request')->with('status', 'Exam request deleted successfully');
    }
    


    


}