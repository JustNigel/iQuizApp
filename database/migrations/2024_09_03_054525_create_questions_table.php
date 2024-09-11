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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('question_text');
            $table->integer('points');
            $table->string('question_type');
            $table->unsignedBigInteger('questionnaire_id');
            $table->string('answer_key');
            $table->timestamps();

            $table->foreign('questionnaire_id')->references('id')->on('exam_questionnaires')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
