<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Questionnaire extends Model
{
    use HasFactory;
    protected $table = 'exam_questionnaires';
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


    /**
     * Relationship between questionnaire and category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ExamCategory::class, 'category_id');
    }


    /**
     * Relationship between questionnaire and specific trainer
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }


    /**
     * 
     * Relationship between questionnaire and all the trainers
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function trainers()
    {
        return $this->belongsToMany(User::class, 'questionnaire_trainer', 'questionnaire_id', 'trainer_id');
    }


    /**
     * Relationship between questionnaire and questions
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class, 'questionnaire_id')->select('id', 'question_type', 'questionnaire_id');
    }
    

    /**
     *  Fetches all questionnaires based on Category ID and optionally Trainer ID.
     * 
     *  If the user is a trainer, it filters questionnaires associated with the authenticated trainer.
     *  If a specific trainer ID is provided, it filters by that trainer. And Questionnaires are ordered 
     *  with 'visible' ones listed first.
     * 
     * @param mixed $categoryId
     * @param mixed $trainerId
     * @return \Illuminate\Database\Eloquent\Collection
     */
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


    /**
     * 
     *  Fetches questionnaires optionally filtered by a trainer.
     *
     *  If a trainer ID is provided, only questionnaires associated with that trainer are returned.
     *  And Results are ordered with 'visible' questionnaires listed first.
     * 
     * @param mixed $trainerId Optional trainer ID to filter questionnaires.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator Paginated list of questionnaires.
     */
    public function getQuestionnairesByTrainer($trainerId = null)
    {
        $query = self::query();
        if ($trainerId) {
            $query->where('trainer_id', $trainerId);
        }
        return $query->orderByRaw('access_status = "visible" DESC')->paginate(10);
    }


    /**
     * Fetches all questionnaires based on Category ID and the associated trainer.
     *
     * If the user is a trainer, it filters the questionnaires associated with the authenticated trainer.
     * If a specific trainer ID is provided, it filters by that trainer. And Questionnaires are ordered 
     * with 'visible' ones listed first.
     *
     * @param mixed $categoryId The ID of the category to filter questionnaires.
     * @param mixed $user The currently authenticated user, used to determine filtering logic.
     * @param mixed $trainerId Optional trainer ID to further filter questionnaires.
     * @return \Illuminate\Database\Eloquent\Collection Collection of filtered questionnaires.
     */
    public static function getAllByCategoryAndTrainer($categoryId, $user, $trainerId = null)
    {
        $query = self::where('category_id', $categoryId);
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


    public static function createFromRequest(array $data)
    {
        self::create([
            'title' => $data['title'],
            'number_of_items' => $data['number_of_items'],
            'time_interval' => $data['time_interval'],
            'passing_grade' => $data['passing_grade'],
            'category_id' => $data['category_id'],
            'trainer_id' => $data['trainer_id'],
            'shuffle' => $data['shuffle'] ?? false,
        ]);
    }
    

    public function toggleVisibility()
    {
        if ($this->access_status === 'hidden') {
            self::where('trainer_id', $this->trainer_id)
                ->where('category_id', $this->category_id)
                ->update(['access_status' => 'hidden']);

            $this->access_status = 'visible';
        } else {
            $this->access_status = 'hidden';
        }

        $this->save();
    }

}
