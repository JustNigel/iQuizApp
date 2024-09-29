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
        return $this->belongsTo(User::class, 'student_id'); // Assuming User model represents students
    }

    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class, 'questionnaire_id');
    }
}
