<?php

namespace Tests\Feature\Models;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use stdClass;
use Tests\Feature\SqlTest;
use Tests\TestCase;

class ProductDTO {
    public $name;
    public $brandName;
    public $categoryName;
    function __construct(stdClass $product)
    {     
        $this->name = $product->name;
        $this->brandName = $product->brand_name;
        $this->categoryName = $product->category_name;
    }
}

class ProductTest extends SqlTest
{
    /**
     * A basic feature test example.
     */
    public function test_orm(): void
    {
        $products = Product::with(['brand', 'category'])->get();
        foreach ($products as $product) {
            $this->assertIsString($product->name);
        }
    }

    public function test_builder1(): void
    {
        $products = DB::table('products', 'p')
            ->select('p.name', 'b.name as brand_name', 'c.name as category_name')
            ->join('brands as b', 'b.id', '=', 'p.brand_id')
            ->join('categories as c', 'c.id', '=', 'p.category_id')
            ->get();
        foreach ($products as $product) {
            $this->assertIsString($product->name);
        }
    }

    public function test_builder2(): void
    {
        $products = DB::table('products', 'p')
            ->select('p.name', 'b.name as brand_name', 'c.name as category_name')
            ->join('brands as b', 'b.id', '=', 'p.brand_id')
            ->join('categories as c', 'c.id', '=', 'p.category_id')
            ->get();
        $products = $products->map(fn ($product) => new ProductDTO($product));
        foreach ($products as $product) {
            $this->assertIsString($product->name);
        }
    }
}
