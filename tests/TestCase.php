<?php

namespace SalvaTerol\MagicLinkLogin\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use SalvaTerol\MagicLinkLogin\MagicLinkLoginServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'SalvaTerol\\MagicLinkLogin\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->artisan('migrate', ['--database' => 'testing'])->run();
    }

    protected function getPackageProviders($app)
    {
        return [
            MagicLinkLoginServiceProvider::class,
            LivewireServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_magic-link-login_table.php.stub';
        $migration->up();
        */
    }
}
