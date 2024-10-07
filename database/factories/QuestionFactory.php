<?php

namespace Database\Factories;

use App\Models\Questionnaire;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question_text' => $this->faker->sentence(), 
            'points' => $this->faker->numberBetween(1, 10), 
            'question_type' => $this->faker->randomElement(['multiple_choice', 'text','paragraph', 'checkboxes', 'drag-drop']), 
            'questionnaire_id' => 13, 
            'answer_key' => json_encode($this->faker->words(2)), 
            'descriptions' => json_encode($this->faker->words(3)), 
            'options' => json_encode($this->faker->words(4)), 
        ];
    }
}
