<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{


    public function availableExam(Request $request)
    {
        $user = Auth::user();
        $query = $request->input('query');

        // Fetch accepted exam requests from confirmed_exam_requests
        $cards = DB::table('confirmed_exam_requests')
            ->where('student_id', $user->id)
            ->join('exam_categories', 'confirmed_exam_requests.category_id', '=', 'exam_categories.id')
            ->join('exam_questionnaires', 'confirmed_exam_requests.questionnaire_id', '=', 'exam_questionnaires.id')
            ->join('users as trainers', 'confirmed_exam_requests.trainer_id', '=', 'trainers.id')
            ->select(
                'exam_categories.title as category_title',
                'exam_questionnaires.title as questionnaire_title',
                'trainers.name as trainer_name',
                'exam_questionnaires.passing_grade as passing_grade',
                'exam_questionnaires.time_interval as time_interval',
                'exam_questionnaires.access_status',
                'confirmed_exam_requests.request_status as request_status' // Add this line to get the visibility status
                
            )
            ->get()
            ->map(function($card) {
                // Create the is_visible property based on access_status
                $card->is_visible = $card->access_status == 'visible'; // Adjust based on your visibility logic
                return $card;
            });

        // Filter results based on the search query, if provided
        if ($query) {
            $cards = $cards->filter(function($card) use ($query) {
                return stripos($card->category_title, $query) !== false || stripos($card->questionnaire_title, $query) !== false;
            });
        }

        if ($request->ajax()) {
            return view('category._cards', compact('cards'))->render();
        }

        return view('category.available-exams', [
            'user' => $user,
            'cards' => $cards,
            'headerTitle' => 'Available Exams' // Pass the header title here
        ]);
    }

    public function index(){

        $user = Auth::user();
        return view('student.dashboard', compact('user'));
    }

    public function history(){
        $user = Auth::user();
        return view('history', compact('user'));
    }
}
