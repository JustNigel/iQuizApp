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
        Schema::table('questions', function (Blueprint $table) {
            $table->string('answer_key')->nullable()->change();
            $table->json('descriptions')->nullable()->change();
            $table->json('matching_key')->nullable()->after('answer_key'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('matching_key'); 
            $table->string('answer_key')->nullable()->change(); 
            $table->text('descriptions')->nullable()->change();
        });
    }
};
