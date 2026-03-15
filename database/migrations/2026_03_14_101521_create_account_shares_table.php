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
        // Schema::create('account_shares', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });

        Schema::create('account_shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('recipient_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('organisation_id')->constrained('organisations')->cascadeOnDelete();
            $table->timestamp('expires_at');
            $table->timestamps();

            // Un owner ne peut pas avoir deux partages actifs vers le même destinataire
            $table->index(['owner_id', 'recipient_id', 'organisation_id']);
        });

        // Pivot : quels comptes sont inclus dans ce partage
        Schema::create('account_share_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_share_id')->constrained('account_shares')->cascadeOnDelete();
            $table->foreignId('account_id')->constrained('accounts')->cascadeOnDelete();
            $table->unique(['account_share_id', 'account_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_share_items');
        Schema::dropIfExists('account_shares');
    }
};
