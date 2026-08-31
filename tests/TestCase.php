<?php

namespace JeffersonGoncalves\WhatsappWidget\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JeffersonGoncalves\WhatsappWidget\WhatsappWidgetServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'JeffersonGoncalves\\WhatsappWidget\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            WhatsappWidgetServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', $this->testing_connection());
    }

    /**
     * Defaults to an in-memory SQLite connection for local development; CI
     * (tests.yml) sets WHATSAPP_WIDGET_TEST_DB_* to run the same suite
     * against real MySQL and PostgreSQL instances too. Deliberately not the
     * plain DB_* names: Orchestra Testbench itself sets DB_CONNECTION=testing
     * by convention, which would collide with (and always win over) a
     * driver value read from the same variable here.
     *
     * @return array<string, mixed>
     */
    protected function testing_connection(): array
    {
        $driver = env('WHATSAPP_WIDGET_TEST_DB_DRIVER', 'sqlite');

        if ($driver === 'sqlite') {
            return ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => ''];
        }

        return [
            'driver' => $driver,
            'host' => env('WHATSAPP_WIDGET_TEST_DB_HOST', '127.0.0.1'),
            'port' => env('WHATSAPP_WIDGET_TEST_DB_PORT'),
            'database' => env('WHATSAPP_WIDGET_TEST_DB_DATABASE', 'testing'),
            'username' => env('WHATSAPP_WIDGET_TEST_DB_USERNAME', 'root'),
            'password' => env('WHATSAPP_WIDGET_TEST_DB_PASSWORD', ''),
            'charset' => $driver === 'pgsql' ? 'utf8' : 'utf8mb4',
            'prefix' => '',
        ];
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
