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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('nin_number')->nullable();
            $table->string('phone')->nullable(); // User's phone number
            $table->string('default_role')->default('User'); // Default role for the user
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedBigInteger('tenant_id')->nullable(); // Tenant reference
            $table->unsignedBigInteger('department_id')->nullable(); // Department reference

            // Foreign key constraints
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('tenant_departments')->onDelete('cascade');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
