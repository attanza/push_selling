<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    // public function setUp()
    // {
    //     parent::setUp();
    //
    //     $this->prepareForTests();
    // }
    //
    // private function prepareForTests()
    // {
    //     Artisan::call('migrate');
    //     Mail::pretend(true);
    // }
}
