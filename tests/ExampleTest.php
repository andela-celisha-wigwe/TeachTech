<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $response = $this->visit('/')
                ->see('TeachTech');

        // $this->assertEquals(300, $response->status());

    }

    public function testAdd()
    {
        $this->assertEquals(1, true);
    }
}
