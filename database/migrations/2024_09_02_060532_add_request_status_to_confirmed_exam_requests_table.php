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
            $table->string('request_status')->default('accepted'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('confirmed_exam_requests', function (Blueprint $table) {
            $table->dropColumn('request_status');
        });
    }
};
