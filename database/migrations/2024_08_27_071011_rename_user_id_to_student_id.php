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
        Schema::table('confirmed_registrations', function (Blueprint $table) {
            $table->renameColumn('user_id', 'student_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('confirmed_registrations', function (Blueprint $table) {
            $table->renameColumn('student_id', 'user_id');
        });
    }
};
