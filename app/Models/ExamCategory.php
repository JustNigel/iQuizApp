<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamCategory extends Model
{
    use HasFactory;

    protected $table = 'exam_categories';

    
    // Define the fillable fields
    protected $fillable = ['title', 'description', 'trainer_id'];

    // Define the relationship to the trainer (user)
    
    public function trainers()
    {
        return $this->belongsToMany(User::class, 'category_trainer', 'category_id', 'trainer_id');
    }

    public function questionnaires()
    {
        return $this->hasMany(Questionnaire::class, 'category_id');
    }

}
