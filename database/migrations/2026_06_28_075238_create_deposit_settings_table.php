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
        Schema::create('deposit_settings', function (Blueprint $table) {
            $table->id();
            $table->string('service_key')->unique();
            $table->enum('deposit_type', ['fixed', 'percentage'])->default('fixed');
            $table->decimal('amount', 12, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposit_settings');
    }
};
