<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = 'questions';
    protected $casts = [
        'options' => 'array', 
    ];

    protected $fillable = [
        'question_text',
        'points',
        'question_type',
        'questionnaire_id',
        'answer_key',
        'descriptions',
        'options',
    ];
    
    public function answerKeys()
    {
        return $this->hasMany(AnswerKey::class, 'question_id');
    }
}
