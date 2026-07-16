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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('brand_id')->constrained()->cascadeOnDelete();
            $table->string('model');
            $table->integer('year')->nullable();
            $table->string('color')->nullable();
            $table->integer('capacity')->default(4);
            $table->decimal('price_per_day', 10, 2);
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->json('images')->nullable();
            $table->integer('total_stock')->default(5);
            $table->integer('available_stock')->default(5);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
