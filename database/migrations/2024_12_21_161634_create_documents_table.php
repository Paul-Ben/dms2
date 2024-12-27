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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('docuent_number');
            $table->string('file_path');
            $table->foreignId('uploaded_by')->constrained('users');
            // $table->foreignId('department_id')->constrained('tenant_departments')->nullable();
            // $table->foreignId('tenant_id')->constrained('tenants')->nullable();
            $table->enum('status', ['pending', 'processing', 'approved', 'rejected', 'kiv', 'completed'])->default('pending'); // pending, approved, rejected
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
