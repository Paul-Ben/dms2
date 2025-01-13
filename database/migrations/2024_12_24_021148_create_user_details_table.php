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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('nin_number')->nullable();
            $table->enum('gender',['male', 'female'])->nullable();
            $table->string('phone_number')->nullable();
            $table->string('designation')->nullable();
            $table->string('avatar')->nullable();
            $table->string('signature')->nullable();
            $table->integer('department_id')->nullable();
            $table->integer('tenant_id')->nullable();
            /**Account type selection fields */
            $table->string('account_type')->nullable(); 
            $table->string('company_name')->nullable(); 
            $table->string('rc_number')->nullable();
            $table->string('company_address')->nullable();
            /**Region selection fields */
            $table->string('region')->nullable();
            $table->string('state')->nullable();
            $table->string('lga')->nullable();
            $table->string('country')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
