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
        Schema::table('users', function (Blueprint $table) {
            $table->string('middle_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('middle_name');
            $table->string('type_name')->default('student')->after('last_name');
            $table->string('gender')->nullable()->after('email_verified_at');
            $table->integer('age')->nullable()->after('gender');
            $table->date('birthday')->nullable()->after('gender');
            $table->string('occupation')->nullable()->after('birthday');
            $table->string('address')->nullable()->after('occupation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
