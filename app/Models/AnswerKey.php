<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerKey extends Model
{
    use HasFactory;
    protected $table = 'answer_keys';

    protected $fillable = [
        'question_id',
        'questionnaire_id',
        'question_type',
        'answer',
        'is_correct',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class, 'questionnaire_id');
    }
}
