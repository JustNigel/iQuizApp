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

    public function assignTrainers(array $trainerIds)
    {
        $trainers = User::whereIn('id', $trainerIds)
                        ->where('type_name', 'trainer')
                        ->get();

        $this->trainers()->attach($trainers->pluck('id')->toArray());
    }


    public function scopeVisibleQuestionnaires($query, $search = null)
    {
        return $query->whereHas('questionnaires', function($q) {
                $q->where('access_status', 'visible');
            })
            ->with(['trainers', 'questionnaires' => function($q) {
                $q->where('access_status', 'visible');
            }])
            ->when($search, function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
            });
    }

}
