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
        Schema::create('answer_keys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('questionnaire_id');
            $table->string('question_type');
            $table->text('answer'); 
            $table->timestamps();
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('questionnaire_id')->references('id')->on('exam_questionnaires')->onDelete('cascade');
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answer_keys');
    }
};
