<?php

namespace App\Http\Controllers\Admin\Parameters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tinsurers;
use Illuminate\Support\Facades\Gate;

class TinsurersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! auth()->user() && auth()->user()->isAllow('users_manage')) {
            return abort(500);
        }

        $datas = Tinsurers::all();
        return view('admin.parameters.tinsurers.index')->with('datas', $datas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! auth()->user() && auth()->user()->isAllow('users_manage')) {
            return abort(500);
        }

        $tinsurer = new Tinsurers;
        $tinsurer->name = $request->add_name;
        $tinsurer->save();

        return redirect()->route('tinsurers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (! auth()->user() && auth()->user()->isAllow('users_manage')) {
            return abort(500);
        }

        $tinsurer = Tinsurers::find($id);
        $tinsurer->name = $request->edit_name;
        $tinsurer->save();
        return redirect()->route('tinsurers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! auth()->user() && auth()->user()->isAllow('users_manage')) {
            return abort(500);
        }

        $tinsurer = Tinsurers::find($id);
        $tinsurer->delete();
    }
}
