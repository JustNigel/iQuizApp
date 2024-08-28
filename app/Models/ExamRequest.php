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

    
}
