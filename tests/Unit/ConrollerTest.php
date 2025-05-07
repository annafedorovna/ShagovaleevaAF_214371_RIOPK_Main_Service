<?php


use App\API\AuthAPITrait;
use App\Http\Controllers\Admin\Configuration\SubagentsController;
use App\Http\Controllers\Admin\Parameters\BrandsController;
use App\Http\Controllers\Admin\Parameters\EscenariesController;
use App\Http\Controllers\Admin\Parameters\InsurersController;
use App\Http\Controllers\Admin\Parameters\StatusesController;
use App\Models\Brands;
use App\Models\Escenaries;
use App\Models\Insurers;
use App\Models\Statuses;
use App\Models\Subagents;
use App\Models\Tinsurers;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ConrollerTest extends TestCase
{
    use AuthAPITrait;

    private function doAuth()
    {
        $user = (object)$this->fetchItem(1);
        $model = new \App\User();
        $model->id = $user->id;
        $model->name = $user->name;
        $model->email = $user->email;
        \Illuminate\Support\Facades\Auth::login($model);

    }

    public function testBrandsConrollerModel()
    {
        $this->doAuth();

        $datas = Brands::all();
        $viewCustom =  view('admin.parameters.brands.index')->with('datas', $datas);
        $this->assertEquals($viewCustom, (new BrandsController())->index());
    }


    public function testEscenariesControllerModel()
    {
        $this->doAuth();

        $datas = Escenaries::leftJoin('insurers', function($join){
            $join->on('escenaries.insurer_id', '=', 'insurers.id');
        })
            ->leftJoin('tproducts', function($join){
                $join->on('escenaries.tproduct_id', '=', 'tproducts.id');
            })
            ->leftJoin('brands', function($join){
                $join->on('escenaries.brand_id', '=', 'brands.id');
            })
            ->leftJoin('models', function($join){
                $join->on('escenaries.model_id', '=', 'models.id');
            })
            ->select('escenaries.*', 'insurers.name as insurername', 'tproducts.name as tproductname', 'brands.name as brandname', 'models.name as modelname')
            ->get();
        $viewCustom =  view('admin.parameters.escenaries.index')->with('datas', $datas);
        $this->assertEquals($viewCustom, (new EscenariesController())->index());
    }


    public function testInsurersControllerModel()
    {
        $this->doAuth();

        $datas = Insurers::leftJoin('tinsurers', function($join){
            $join->on('tinsurers.id', '=', 'insurers.type_id');
        })
            ->select('insurers.*', 'tinsurers.name as typename')
            ->get();
        $types = Tinsurers::all();
        $viewCustom =  view('admin.parameters.insurers.index')->with('datas', $datas)->with('types', $types);
        $this->assertEquals($viewCustom, (new InsurersController())->index());
    }

    public function testStatusesControllerModel()
    {
        $this->doAuth();

        $datas = Statuses::all();

        $viewCustom = view('admin.parameters.statuses.index')->with('datas', $datas);
        $this->assertEquals($viewCustom, (new StatusesController())->index());
    }
    public function testSubagentsControllerModel()
    {
        $this->doAuth();

        $datas = Subagents::all();
        $viewCustom =  view('admin.configuration.subagents.index')->with('datas', $datas);
        $this->assertEquals($viewCustom, (new SubagentsController())->index());
    }

}
