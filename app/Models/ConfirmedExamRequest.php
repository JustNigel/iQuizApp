<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfirmedExamRequest extends Model
{
    use HasFactory;

    protected $table = 'confirmed_exam_requests';


    /**
     * Get the confirmed exam request for a student, category, trainer, and questionnaire.
     *
     * @param int $studentId
     * @param int $categoryId
     * @param int $trainerId
     * @param int $questionnaireId
     * @return ConfirmedExamRequest|null
     */
    public static function getConfirmedRequest($studentId, $categoryId, $trainerId, $questionnaireId)
    {
        return self::where('student_id', $studentId)
                    ->where('category_id', $categoryId)
                    ->where('trainer_id', $trainerId)
                    ->where('questionnaire_id', $questionnaireId)
                    ->first();
    }
}
