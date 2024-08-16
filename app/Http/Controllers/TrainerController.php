<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function index(){
        $user = auth()->user();
        return view('trainer.dashboard.dashboard', compact('user'));
    }
}
