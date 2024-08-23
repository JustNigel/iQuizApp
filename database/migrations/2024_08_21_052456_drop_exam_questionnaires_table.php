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
        Schema::dropIfExists('exam_questionnaires');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('exam_questionnaires', function (Blueprint $table) {
            $table->id(); // Primary key with auto-increment
            $table->string('title'); // Title of the questionnaire
            $table->integer('number_of_items'); // Number of items in the questionnaire
            $table->integer('time_interval'); // Time limit for the questionnaire in minutes
            $table->integer('passing_grade')->nullable(); // Passing grade percentage (nullable)
            $table->unsignedBigInteger('category_id'); // Foreign key to exam_categories table
            $table->unsignedBigInteger('trainer_id'); // Foreign key to users table (only trainers)
            $table->boolean('shuffle')->default(false); // Indicates whether questions should be shuffled
            $table->timestamps(); // Created and updated timestamps

            // Foreign key constraints
            $table->foreign('category_id')
                ->references('id')
                ->on('exam_categories')
                ->onDelete('cascade');

            $table->foreign('trainer_id')
                ->references('trainer_id')
                ->on('exam_categories')
                ->onDelete('cascade');
        });
    }
};
