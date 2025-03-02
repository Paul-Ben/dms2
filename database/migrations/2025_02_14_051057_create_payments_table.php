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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('businessName');
            $table->string('reference');
            $table->double('transAmount');
            $table->double('transFee');
            $table->double('transTotal');
            $table->string('transDate');
            $table->string('settlementAmount');
            $table->integer('status');
            $table->string('statusMessage');
            $table->string('customerEmail');
            $table->foreignId('customerId')->constrained('users');
            $table->integer('channelId');
            $table->string('currencyCode');
            $table->foreignId('recipient_id')->constrained('users');
            $table->integer('tenant_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
