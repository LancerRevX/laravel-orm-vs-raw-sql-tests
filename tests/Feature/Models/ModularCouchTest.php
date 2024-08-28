<?php

namespace Tests\Feature\Models;

use App\Models\ModularCouch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\Feature\SqlTest;
use Tests\TestCase;

class ModularCouchTest extends SqlTest
{
    /**
     * A basic feature test example.
     */
    public function test_orm1(): void
    {
        $couches = ModularCouch::all();
        foreach ($couches as $couch) {
            $this->assertIsInt($couch->price_min1);
        }
    }

    public function test_orm2(): void
    {
        $couches = ModularCouch::all();
        foreach ($couches as $couch) {
            $this->assertIsInt($couch->price_min2);
        }
    }

    public function test_orm3(): void
    {
        $couches = ModularCouch::with('parts')->get();
        foreach ($couches as $couch) {
            $this->assertIsInt($couch->price_min2);
        }
    }

    public function test_builder(): void
    {
        $couches = DB::table('modular_couches', 'c')
            ->select('c.id', DB::raw('min(p.price) as price_min'))
            ->join('modular_couch_parts as p', 'p.couch_id', '=', 'c.id')
            ->groupBy('c.id')
            ->get();
        foreach ($couches as $couch) {
            $this->assertIsInt($couch->price_min);
        }
    }
}
