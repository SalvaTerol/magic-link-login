<?php

namespace SalvaTerol\MagicLinkLogin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SalvaTerol\MagicLinkLogin\MagicLinkLogin
 */
class MagicLinkLogin extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \SalvaTerol\MagicLinkLogin\MagicLinkLogin::class;
    }
}
