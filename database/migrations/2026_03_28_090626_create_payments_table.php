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
            $table->foreignId('organisation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('recorded_by')->constrained('users')->cascadeOnDelete(); // admin qui enregistre
            $table->enum('plan', ['starter', 'pro', 'enterprise']);
            $table->enum('payment_method', ['cash', 'bank_transfer'])->default('cash');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)->default('KMF');
            $table->unsignedTinyInteger('duration_months')->default(1); // durée achetée
            $table->timestamp('paid_at');
            $table->timestamp('period_start');
            $table->timestamp('period_end');
            $table->text('notes')->nullable();
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
