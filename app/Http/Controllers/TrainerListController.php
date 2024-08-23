<?php

namespace App\Http\Controllers;

use App\Models\ExamCategory;
use App\Models\User;
use Illuminate\Http\Request;

class TrainerListController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // Fetch all trainers with their associated categories
        $last_name = User::where('last_name')->get();
        $trainers = User::where('type_name', 'trainer')->with('examCategories')->get(); 

        return view('admin.all-trainers', ['user' =>$user,
            'last_name'  => $last_name,
            'trainers' => $trainers
        ]);
    }
    public function editTrainer($id){
        $user = auth()->user();
        $trainers = User::where('type_name', 'trainer')->get(); 
        return view('admin.add-trainer', compact('trainers','user'));
    }

    public function showTrainerDeleteConfirmation($id)
    {
        $user = auth()->user();
        $trainer = User::findOrFail($id);
        return view('admin.delete-trainer', compact('trainer','user'));
    }
public function deleteTrainer($id)
{
    // Find the trainer by ID
    $trainer = User::where('type_name', 'trainer')->findOrFail($id);

    // Remove the association with the trainer but keep the category existing
    ExamCategory::where('trainer_id', $trainer->id)->update(['trainer_id' => null]);

    // Now delete the trainer
    $trainer->delete();

    return redirect()->route('admin.all-trainers')->with('success', 'Trainer deleted successfully, but associated categories are retained!');
}

    
    
    
    
    
}
