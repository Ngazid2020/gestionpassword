<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organisations', function (Blueprint $table) {
            $table->enum('plan', ['starter', 'pro', 'enterprise'])->default('starter')->after('active');
            $table->enum('subscription_status', ['trial', 'active', 'expired', 'cancelled'])->default('trial')->after('plan');
            $table->timestamp('trial_ends_at')->nullable()->after('subscription_status');
            $table->timestamp('subscription_ends_at')->nullable()->after('trial_ends_at');
        });

        // Mettre à jour les organisations existantes : trial de 14j à partir de leur création
        DB::statement("
            UPDATE organisations
            SET subscription_status = 'trial',
                trial_ends_at = DATE_ADD(created_at, INTERVAL 14 DAY)
            WHERE trial_ends_at IS NULL
        ");
    }

    public function down(): void
    {
        Schema::table('organisations', function (Blueprint $table) {
            $table->dropColumn(['plan', 'subscription_status', 'trial_ends_at', 'subscription_ends_at']);
        });
    }
};