<?php

namespace App\Console\Commands;

use App\Models\Organisation;
use Illuminate\Console\Command;

class ExpireSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:expire-subscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // Essais expirés
        $trialExpired = Organisation::where('subscription_status', 'trial')
            ->where('trial_ends_at', '<=', now())
            ->update(['subscription_status' => 'expired', 'active' => false]);

        // Abonnements actifs expirés
        $subExpired = Organisation::where('subscription_status', 'active')
            ->where('subscription_ends_at', '<=', now())
            ->update(['subscription_status' => 'expired', 'active' => false]);

        $total = $trialExpired + $subExpired;

        $this->info("✅ {$total} organisation(s) marquée(s) comme expirées.");
        $this->line("   · Essais : {$trialExpired}");
        $this->line("   · Abonnements : {$subExpired}");

        return self::SUCCESS;
    }
}
