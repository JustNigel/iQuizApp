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
        Schema::table('exam_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('questionnaire_id')->nullable()->after('trainer_id');

            $table->foreign('questionnaire_id')->references('id')->on('exam_questionnaires')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_requests', function (Blueprint $table) {
            //
        });
    }
};
