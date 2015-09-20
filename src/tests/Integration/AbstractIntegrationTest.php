<?php namespace Tests\Integration;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\AbstractTestCase;

abstract class AbstractIntegrationTest extends AbstractTestCase
{

    use DatabaseTransactions, DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->runDatabaseMigrations();
    }
}
