<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::boot();
        Artisan::call('migrate:fresh');
    }

    public function setUp(): void
    {
        parent::setUp();

        self::boot();
        Artisan::call('migrate:fresh');
    }
}
