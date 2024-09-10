<?php

namespace SalvaTerol\MagicLinkLogin\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use SalvaTerol\MagicLinkLogin\Models\MagicLink;

class CleanupExpiredMagicLinks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct() {}

    public function handle(): void
    {
        $expiredLinks = MagicLink::where('expires_at', '<', now()->addMinutes(config(key: 'magic-link-login.token_expiry_minutes', default: 30)))->delete();

        Log::info('Se eliminaron '.$expiredLinks.' enlaces mágicos expirados.');
    }
}
