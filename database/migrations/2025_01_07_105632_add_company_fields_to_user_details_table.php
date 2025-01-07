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
            //
            $table->string('account_type')->nullable(); 
            $table->string('company_name')->nullable(); 
            $table->string('rc_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_details', function (Blueprint $table) {
            //
            $table->dropColumn('account_type'); 
            $table->dropColumn('company_name'); 
            $table->dropColumn('rc_number');
        });
    }
};
