<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamRequest extends Model
{
    use HasFactory;

    protected $table = 'exam_requests';

    protected $fillable = [
        'student_id',
        'category_id',
        'trainer_id',
        'questionnaire_id',
        'request_status',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class, 'questionnaire_id');
    }
    

    /**
     * Get the existing exam request for a student, category, trainer, and questionnaire.
     *
     * @param int $studentId
     * @param int $categoryId
     * @param int $trainerId
     * @param int $questionnaireId
     * @return ExamRequest|null
     */
    public static function getExistingRequest($studentId, $categoryId, $trainerId, $questionnaireId)
    {
        return self::where('student_id', $studentId)
                    ->where('category_id', $categoryId)
                    ->where('trainer_id', $trainerId)
                    ->where('questionnaire_id', $questionnaireId)
                    ->first();
    }
    
}
