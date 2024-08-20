<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamCategory;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function edit($id)
    {

        $user = auth()->user();
        $category = ExamCategory::findOrFail($id);
        $trainers = User::where('type_name', 'trainer')->get(); 
    
        return view('admin.edit', compact('category', 'trainers','user'));
    }
    
    public function update(Request $request, $id)
    {
        $category = ExamCategory::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('admin.all-category')->with('success', 'Category updated successfully!');
    }

}

