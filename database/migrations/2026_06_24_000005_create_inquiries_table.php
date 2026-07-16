<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('phone')->nullable();
            $table->string('email');
            $table->string('subject');
            $table->text('message');
            $table->text('admin_response')->nullable();
            $table->enum('status', ['open', 'resolved'])->default('open');
            $table->dateTime('resolved_at')->nullable();
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
