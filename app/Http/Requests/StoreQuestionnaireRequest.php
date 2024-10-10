<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionnaireRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'number_of_items' => 'required|integer',
            'time_interval' => 'required|integer',
            'passing_grade' => 'nullable|integer',
            'category_id' => 'required|exists:exam_categories,id',
            'trainer_id' => 'required|array',
            'trainer_id.*' => 'exists:users,id',
            'shuffle' => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return [
            'trainer_id.required' => 'You should choose a trainer.',
        ];
    }

    public function validateTrainerId()
    {
        if (is_null($this->input('trainer_id'))) {
            return back()->withInput()->with('error', 'You should choose a trainer.');
        }
    }

}
