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
        Schema::table('confirmed_exam_requests', function (Blueprint $table) {
         // Drop the existing foreign key constraint on 'questionnaire_id'
         $table->dropForeign(['questionnaire_id']);

         // Re-add the foreign key with 'onDelete(cascade)'
         $table->foreign('questionnaire_id')
               ->references('id')->on('exam_questionnaires')
               ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('confirmed_exam_requests', function (Blueprint $table) {
            $table->dropForeign(['questionnaire_id']);

            // Re-add the original foreign key (without cascading delete)
            $table->foreign('questionnaire_id')
                  ->references('id')->on('exam_questionnaires');
        });
    }
};
