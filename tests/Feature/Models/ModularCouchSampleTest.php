<?php

namespace Tests\Feature\Models;

use App\Models\ModularCouchPart;
use App\Models\ModularCouchSample;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\Feature\SqlTest;
use Tests\TestCase;

class ModularCouchSampleTest extends SqlTest
{
    /**
     * A basic feature test example.
     */
    public function test_price(): void
    {
        foreach (ModularCouchSample::all() as $sample) {
            $price = 0;
            foreach ($sample->parts as $part) {
                $price += $part->price * $part->pivot->count;
            }
            $this->assertEquals($price, $sample->price);
        }
    }

    public function test_orm1(): void 
    {
        $samples = ModularCouchSample::all();
        foreach ($samples as $sample) {
            $this->assertIsInt($sample->price);
        }
    }

    public function test_orm2(): void 
    {
        $samples = ModularCouchSample::with('parts')->get();
        foreach ($samples as $sample) {
            $this->assertIsInt($sample->price);
        }
    }

    public function test_builder(): void
    {
        $samples = DB::table('modular_couch_samples', 's')
            ->select('s.id', DB::raw('sum(p.price * c.count) as price'))
            ->join('modular_couch_parts as p', 'c.part_id', '=', 'p.id')
            ->join('modular_couch_part_sample as c', 'c.sample_id', '=', 's.id')
            ->groupBy('s.id')
            ->get();
        foreach ($samples as $sample) {
            // $this->assertEquals(ModularCouchSample::find($sample->id)->price, $sample->price);
            $this->assertIsInt($sample->price);
        }
    }
}
