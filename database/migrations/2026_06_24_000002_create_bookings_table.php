<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('booking_number')->unique();
           
            $table->enum('status', ['pending', 'confirmed', 'active', 'completed', 'cancelled'])->default('pending');
            $table->dateTime('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();

             $table->decimal('car_deposit_snapshot', 12, 2)->default(0);
            $table->decimal('driver_deposit_snapshot', 12, 2)->default(0);

            $table->decimal('subtotal_price', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('total_price', 12, 2)->default(0);

            $table->softDeletes();
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
