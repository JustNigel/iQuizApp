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
            $table->string('request_status'); 
            $table->timestamps();

            $table->foreign('student_id')->references('student_id')->on('confirmed_registrations')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('exam_categories')->onDelete('cascade');
            $table->foreign('trainer_id')->references('id')->on('users')->onDelete('cascade'); // Assuming trainers are in the users table
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
