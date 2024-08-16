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
        Schema::create('exam_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('trainer_id')->constrained('users'); 
            $table->boolean('shuffle')->default(false); 
            $table->integer('total_students')->nullable();
            $table->integer('total_respondents')->nullable();
            $table->integer('total_questions')->nullable();
            $table->integer('max_questions')->nullable(); 
            $table->integer('passing_score')->nullable(); 
            $table->integer('time_limit')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_categories');
    }
};
