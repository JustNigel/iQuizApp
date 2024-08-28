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
        Schema::create('exam_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('trainer_id');
            $table->string('request_status')->default('pending');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('student_id')->references('student_id')->on('confirmed_registrations')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('exam_categories')->onDelete('cascade');
            $table->foreign('trainer_id')->references('trainer_id')->on('category_trainer')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_requests');
    }
};
