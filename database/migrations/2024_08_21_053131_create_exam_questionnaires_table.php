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
            $table->string('title');
            $table->integer('number_of_items');
            $table->integer('time_interval');
            $table->integer('passing_grade')->nullable();
            $table->foreignId('category_id')->constrained('exam_categories')->onDelete('cascade');
            $table->foreignId('trainer_id')->constrained('users')->onDelete('cascade');
            $table->boolean('shuffle')->default(false);
            $table->timestamps();
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
