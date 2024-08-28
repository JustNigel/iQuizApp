<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;
    protected $table = 'exam_questionnaires';

    // Define the fillable fields
    protected $fillable = [
        'title',
        'number_of_items',
        'time_interval',
        'passing_grade',
        'category_id',
        'trainer_id',
        'shuffle',
        'access_status',
    ];

    public function category()
    {
        return $this->belongsTo(ExamCategory::class, 'category_id');
    }

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    /**
     * 
     * Pivot Table for Questionnaire and Trainer
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function trainers()
    {
        return $this->belongsToMany(User::class, 'questionnaire_trainer', 'questionnaire_id', 'trainer_id');
    }


}
