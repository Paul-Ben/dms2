<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('folders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('folders')->onDelete('cascade');
            $table->boolean('is_private')->default(false);
            $table->timestamps();
        });

        // Create folder permissions table
        Schema::create('folder_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('folder_id')->constrained('folders')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('permission', ['read', 'write', 'admin']);
            $table->timestamps();
        });

        // Add folder_id to documents table
        Schema::table('documents', function (Blueprint $table) {
            $table->foreignId('folder_id')->nullable()->constrained('folders')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['folder_id']);
            $table->dropColumn('folder_id');
        });
        
        Schema::dropIfExists('folder_permissions');
        Schema::dropIfExists('folders');
    }
}; 