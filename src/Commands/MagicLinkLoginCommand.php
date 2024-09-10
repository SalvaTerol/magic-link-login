<?php

namespace SalvaTerol\MagicLinkLogin\Commands;

use Illuminate\Console\Command;
use SalvaTerol\MagicLinkLogin\Jobs\CleanupExpiredMagicLinks;

class MagicLinkLoginCommand extends Command
{
    protected $signature = 'magic-links:cleanup';

    protected $description = 'Eliminar enlaces mágicos expirados de la base de datos';

    public function handle()
    {
        CleanupExpiredMagicLinks::dispatch();

        $this->info('Los enlaces mágicos expirados han sido eliminados.');
    }
}
