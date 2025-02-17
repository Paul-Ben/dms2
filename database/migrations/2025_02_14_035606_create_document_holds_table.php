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
        Schema::create('document_holds', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('docuent_number');
            $table->string('file_path');
            $table->foreignId('uploaded_by')->constrained('users');
            $table->string('status')->default('pending'); 
            $table->text('description')->nullable();
            $table->string('reference');
            $table->string('amount');
            $table->foreignId('recipient_id')->constrained('users');
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_holds');
    }
};
