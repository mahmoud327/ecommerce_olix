<?php

namespace Tests;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('passport:install');

        // $this->artisan('migrate:fresh');
        $this->runDatabaseMigrations();
    }
}
