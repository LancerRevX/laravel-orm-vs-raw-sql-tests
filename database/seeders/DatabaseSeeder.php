<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Mattress;
use App\Models\MattressSample;
use App\Models\ModularCouch;
use App\Models\ModularCouchPart;
use App\Models\ModularCouchSample;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Mattress::factory(config('app.mattresses_count'))
            ->has(MattressSample::factory(config('app.mattress_samples_count')), relationship: 'samples')
            ->create();

        ModularCouch::factory(config('app.modular_couches_count'))
            ->has(ModularCouchPart::factory(config('app.modular_couch_parts_count')), relationship: 'parts')
            ->has(ModularCouchSample::factory(config('app.modular_couch_samples_count')), relationship: 'samples')
            ->create();
        ModularCouch::all()->each(function ($couch) {
            $couch->samples->each(function ($sample) use ($couch) {
                $couch->parts->each(function ($part) use ($sample) {
                    DB::table('modular_couch_part_sample')
                        ->insert([
                            'sample_id' => $sample->id,
                            'part_id' => $part->id,
                            'count' => fake()->numberBetween(1, 3),
                        ]);
                });
            });
        });

        Brand::factory(config('app.brands_count'))->create();
        Category::factory(config('app.categories_count'))->create();
        Product::factory(config('app.products_count'))->create();
    }
}
