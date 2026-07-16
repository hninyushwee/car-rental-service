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
        if (!Schema::hasTable('booking_items')) {
            Schema::create('booking_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
                $table->foreignId('vehicle_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('driver_id')->nullable()->constrained()->nullOnDelete();
                $table->boolean('has_driver')->default(false);

                $table->integer('quantity')->default(1);

                $table->dateTime('start_date');
                $table->dateTime('end_date');
                $table->dateTime('actual_return_date')->nullable();
                $table->text('pickup_location');
                $table->text('dropoff_location');

                $table->decimal('vehicle_daily_rate', 12, 2)->default(0);
                $table->decimal('driver_daily_rate', 12, 2)->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_items');
    }
};
