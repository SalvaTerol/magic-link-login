<?php

namespace SalvaTerol\MagicLinkLogin;

use Livewire\Livewire;
use SalvaTerol\MagicLinkLogin\Commands\MagicLinkLoginCommand;
use SalvaTerol\MagicLinkLogin\Http\Livewire\Login;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MagicLinkLoginServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('magic-link-login')
            ->hasViews()
            ->hasConfigFile()
            ->hasRoute('web')
            ->hasMigration('create_magic_link_login_table')
            ->hasViews('magic-link-login::pages.login')
            ->hasViews('magic-link-login::mail.login')
            ->hasCommand(MagicLinkLoginCommand::class)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishAssets()
                    ->publishMigrations()
                    ->copyAndRegisterServiceProviderInApp();
            });
    }

    public function packageBooted()
    {
        Livewire::component('login', Login::class);
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'magic-link-login');
    }
}
