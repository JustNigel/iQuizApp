<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function exam(Questionnaire $questionnaire){
        $user = Auth::user();
        return view('student-questionnaire.get-started', compact('user', 'questionnaire'));
    }

}
