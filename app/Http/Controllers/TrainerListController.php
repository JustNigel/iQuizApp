<?php

namespace App\Http\Controllers;

use App\Models\ExamCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainerListController extends Controller
{
    public function index(){
        $user = Auth::user();
        $trainers = User::where('type_name', 'trainer')
            ->with(['examCategories' => function ($query) { $query->take(3); }])
            ->get();
        $last_name = User::whereNotNull('last_name')
            ->get();

        return view('admin.all-trainers', [
            'user' => $user,
            'last_name' => $last_name,
            'trainers' => $trainers
        ]);
    }

    public function editTrainer($id){
        $user = Auth::user();
        $trainers = User::where('type_name', 'trainer')
            ->get(); 

        return view('admin.add-trainer', compact('trainers','user'));
    }

    public function showTrainerDeleteConfirmation($id){
        $user = Auth::user();
        $trainer = User::findOrFail($id);

        return view('admin.delete-trainer', compact('trainer','user'));
    }
    public function deleteTrainer($id){
        $trainer = User::where('type_name', 'trainer')
            ->findOrFail($id);
        ExamCategory::where('trainer_id', $trainer->id)
            ->update(['trainer_id' => null]);
        $trainer->delete();

        return redirect()->route('admin.all-trainers')
            ->with('success', 'Trainer deleted successfully, but associated categories are retained!');
    }

    
    
    
    
    
}
