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
        Schema::table('user_details', function (Blueprint $table) {
            $table->string('psn')->nullable()->after('tenant_id');
            $table->string('grade_level')->nullable();
            $table->string('rank')->nullable();
            $table->string('schedule')->nullable();
            $table->string('employment_date')->nullable();
            $table->string('date_of_birth')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn('psn');
            $table->dropColumn('grade_level');
            $table->dropColumn('rank');
            $table->dropColumn('schedule');
            $table->dropColumn('employment_date');
            $table->dropColumn('date_of_birth');
        });
    }
};
