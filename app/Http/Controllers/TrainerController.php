<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function index(){
        $user = auth()->user();
        return view('trainer.dashboard.dashboard', compact('user'));
    }

    public function displayAllCategory(){
        $user = auth()->user();
        $categories = $user->examCategories()->get();
    
        return view('trainer.all-category', compact('categories', 'user'));
    }
    

}
