<?php

namespace Tests\Feature\Models;

use App\Models\Mattress;
use App\Models\Mattress2;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\Feature\SqlTest;
use Tests\TestCase;

class MattressTest extends SqlTest
{
    /**
     * A basic feature test example.
     */
    public function test_orm1(): void
    {
        $mattresses = Mattress::all();
        $this->assertCount(
            config('app.mattresses_count'),
            $mattresses
        );
        $mattresses->each(function ($mattress) {
            $this->assertIsInt($mattress->price_min1);
            $this->assertIsInt($mattress->price_max1);
        });
    }

    public function test_orm2(): void
    {
        $mattresses = Mattress::all();
        $this->assertCount(
            config('app.mattresses_count'),
            $mattresses
        );
        $mattresses->each(function ($mattress) {
            $this->assertIsInt($mattress->price_min2);
            $this->assertIsInt($mattress->price_max2);
        });
    }

    public function test_orm3(): void
    {
        $mattresses = Mattress::with('samples')->get();
        $this->assertCount(
            config('app.mattresses_count'),
            $mattresses
        );
        $mattresses->each(function ($mattress) {
            $this->assertIsInt($mattress->price_min2);
            $this->assertIsInt($mattress->price_max2);
        });
    }

    public function test_orm4(): void
    {
        $mattresses = Mattress::with('samples')->get();
        $this->assertCount(
            config('app.mattresses_count'),
            $mattresses
        );
        $mattresses->each(function ($mattress) {
            $this->assertIsInt($mattress->price_min1);
            $this->assertIsInt($mattress->price_max1);
        });
    }

    public function test_builder(): void
    {
        $mattresses = DB::table('mattresses', 'm')
            ->select('m.id', DB::raw('min(s.price) as price_min'), DB::raw('max(s.price) as price_max'))
            ->join('mattress_samples as s', 's.mattress_id', '=', 'm.id')
            ->groupBy('m.id')
            ->get();
        $this->assertCount(
            config('app.mattresses_count'),
            $mattresses
        );
        $mattresses->each(function ($mattress) {
            $this->assertIsInt($mattress->price_min);
            $this->assertIsInt($mattress->price_max);
        });
    }
}
