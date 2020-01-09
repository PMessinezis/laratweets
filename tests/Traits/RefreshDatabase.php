<?php

namespace Tests\Traits;

use Illuminate\Contracts\Console\Kernel;

trait RefreshDatabase
{
    use \Illuminate\Foundation\Testing\RefreshDatabase;

    /**
     * Begin a database transaction on the testing database.
     *
     * @return void
     */
    public function beginDatabaseTransaction()
    {
        $connection = $this->app->make('em')->getConnection();
        dd($connection);
        $connection->beginTransaction();

        $this->beforeApplicationDestroyed(function () use ($connection) {
            $connection->rollBack();
        });
    }

    /**
     * Refresh the in-memory database.
     *
     * @return void
     */
    protected function refreshInMemoryDatabase()
    {
        $this->artisan('doctrine:schema:create');

        $this->app[Kernel::class]->setArtisan(null);
    }
}
