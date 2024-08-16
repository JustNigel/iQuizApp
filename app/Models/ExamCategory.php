<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamCategory extends Model
{
    use HasFactory;

    // Define the fillable fields
    protected $fillable = ['title', 'description', 'trainer_id'];

    // Define the relationship to the trainer (user)
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}
