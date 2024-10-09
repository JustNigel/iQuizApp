<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function exam(Questionnaire $questionnaire)
    {
        $user = Auth::user();
        $questions = $questionnaire->questions();
        if ($questionnaire->shuffle) {
            $questions = $questions->inRandomOrder()->get();
        } else {
            $questions = $questions->get();
        }
        $question = $questions->first();

        return view('student-questionnaire.get-started', compact('user', 'questionnaire', 'question'));
    }

    public function displayQuestion(Question $question)
    {
        $user = Auth::user();
        
        // Retrieve the questionnaire associated with the question
        $questionnaire = $question->questionnaire; // assuming there's a 'questionnaire' relationship in the Question model

        // Check question type
        $choices = $question->question_type;

        switch ($choices) {
            case 'multiple-choice':
                return view('student-questionnaire.multiple-choice', compact('question', 'user', 'questionnaire'));
            case 'checkboxes':
                return view('student-questionnaire.checkboxes', compact('question', 'user', 'questionnaire'));
            case 'text':
                return view('student-questionnaire.text', compact('question', 'user', 'questionnaire'));
            case 'paragraph':
                return view('student-questionnaire.paragraph', compact('question', 'user', 'questionnaire'));
            case 'drag-drop':
                return view('student-questionnaire.drag-drop', compact('question', 'user', 'questionnaire'));
            case 'matching':
                return view('student-questionnaire.matching', compact('question', 'user', 'questionnaire'));  
            default:
                // Handle the case where question type is not recognized
                return redirect()->back()->with('error', 'Question type not supported.');
        }
    }

}
