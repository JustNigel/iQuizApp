<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exam_questionnaires', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); // Stores the name of the questionnaire
            $table->integer('number_of_items')->nullable(); // Number of questions in the questionnaire
            $table->integer('time_interval')->nullable(); // Time limit for the questionnaire in minutes
            $table->integer('passing_grade')->nullable(); // Passing grade percentage
            $table->unsignedBigInteger('category_id')->nullable(); // Foreign key to exam_categories table
            $table->unsignedBigInteger('trainer_id')->nullable(); // Foreign key to users table (only trainers)
            $table->boolean('shuffle')->default(false); // Indicates whether questions should be shuffled
            $table->timestamps();
        
            // Foreign key constraints
            $table->foreign('category_id')
                ->references('id')
                ->on('exam_categories') // Make sure this references the correct table
                ->onDelete('cascade');
        
            $table->foreign('trainer_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_questionnaires');
    }
};
