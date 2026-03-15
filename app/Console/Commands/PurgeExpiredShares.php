<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AccountShare;

class PurgeExpiredShares extends Command
{
    protected $signature   = 'shares:purge';
    protected $description = 'Supprime les partages de comptes expirés';

    public function handle(): int
    {
        $deleted = AccountShare::expired()->delete();

        $this->info("✓ {$deleted} partage(s) expiré(s) supprimé(s).");

        return self::SUCCESS;
    }
}
