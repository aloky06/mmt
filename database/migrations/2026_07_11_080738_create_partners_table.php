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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // If linked to an existing customer
            $table->string('name');
            $table->string('email')->unique();
            $table->string('referral_code')->unique();
            $table->enum('commission_type', ['flat', 'percentage'])->default('percentage');
            $table->decimal('commission_value', 10, 2)->default(10.00); // 10% or Rs 10
            $table->string('payment_method')->nullable();
            $table->text('payment_details')->nullable(); // JSON
            $table->enum('status', ['pending', 'active', 'suspended'])->default('active');
            $table->string('pan_number')->nullable(); // For Indian context
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
