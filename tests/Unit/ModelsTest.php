<?php


use App\API\AuthAPITrait;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ModelsTest extends TestCase
{
    use AuthAPITrait;

    public function testBrandModel()
    {
        $brands = \App\Models\Brands::query()->get();;
        
        $this->assertNotEquals($brands->count(), 0);
        $this->assertNotNull($brands->first()->name);
        $this->assertNotNull($brands->first()->created_at);
    }

    public function testProductModel()
    {
        $products = \App\Models\Products::query()->get();;

        $this->assertNotEquals($products->count(), 0);
        $this->assertNotNull($products->first()->model_id);
        $this->assertNotNull($products->first()->created_at);
        $this->assertNotNull(\App\Models\Models::find($products->first()->model_id));
    }

    public function testUseModel()
    {
        $uses = \App\Models\Uses::query()->get();;

        $this->assertNotEquals($uses->count(), 0);
        $this->assertNotNull($uses->first()->id);
        $this->assertNotNull($uses->first()->name);
        $this->assertNotNull($uses->first()->created_at);
        $this->assertNotNull($uses->first()->updated_at);
    }

    public function testSubagentModel()
    {
        $subagents = \App\Models\Subagents::query()->get();;

        $this->assertNotEquals($subagents->count(), 0);
        $this->assertNotNull($subagents->first());
    }

    public function testInsurerModel()
    {
        $insurers = \App\Models\Insurers::query()->get();;

        $this->assertNotEquals($insurers->count(), 0);
        $this->assertTrue(is_int($insurers->first()->id));
        $this->assertTrue(is_int($insurers->first()->type_id));
    }

}
