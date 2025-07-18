<?php

namespace Tests\App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;

class JajalTest extends CIUnitTestCase
{
    use ControllerTestTrait;

    public function testIndexReturnsView()
    {
        $result = $this->withURI('http://localhost/jajal')->controller(\App\Controllers\Jajal::class)
            ->execute('index');

        $result->assertOK(); // pastikan status 200
        $result->assertViewIs('main/jajal'); // pastikan view yg dikembalikan benar
    }
}
