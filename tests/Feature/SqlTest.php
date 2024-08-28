<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SqlTest extends TestCase
{
    private float $startTime;

    function setUp(): void
    {
        parent::setUp();
        DB::enableQueryLog();
        DB::flushQueryLog();
        $this->startTime = microtime(true);
    }

    function tearDown(): void
    {
        $timePassed = microtime(true) - $this->startTime;
        error_log("Time passed: $timePassed");
        $queriesNumber = count(DB::getQueryLog());
        error_log("Queries number: {$queriesNumber}");
        // foreach (DB::getQueryLog() as $query) {
        //     error_log($query['query']);
        // }
        DB::flushQueryLog();
        DB::disableQueryLog();
        parent::tearDown();
    }
}
