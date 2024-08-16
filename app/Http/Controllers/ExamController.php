<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function exam(){
        return view('student.exam');
    }

}
