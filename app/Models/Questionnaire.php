<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public function questions()
    {
        return $this->hasMany(Question::class, 'questionnaire_id')->select('id', 'question_type', 'questionnaire_id');
    }
    



    public function getQuestionnairesByCategoryAndTrainer($categoryId, $trainerId = null)
    {
        $user = Auth::user();
        $query = Questionnaire::where('category_id', $categoryId);
        if ($user->type_name === 'trainer') {
            $query->whereHas('trainers', function ($q) use ($user) {
                $q->where('trainer_id', $user->id);
            });
        } elseif ($trainerId) {
            $query->whereHas('trainers', function ($q) use ($trainerId) {
                $q->where('trainer_id', $trainerId);
            });
        }
        
        return $query->orderByRaw("CASE WHEN access_status = 'visible' THEN 0 ELSE 1 END")->get();
    }


    public function getQuestionnairesByTrainer($trainerId = null)
    {
        $query = self::query();

        if ($trainerId) {
            $query->where('trainer_id', $trainerId);
        }

        return $query->orderByRaw('access_status = "visible" DESC')->paginate(10);
    }



    

}
