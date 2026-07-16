<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->morphs('payable');
            $table->enum('payment_method', ['cash', 'kpay', 'wavepay', 'card', 'bank_transfer']);
            $table->string('transaction_ref')->unique();
            $table->string('image')->nullable();
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
            $table->dateTime('payment_date')->nullable();
            $table->decimal('amount', 12, 2);
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
