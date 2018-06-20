<?php

namespace App\Http\Controllers;

use App\Http\Requests\AreaRequest;
use Auth;
use Illuminate\Http\Request;
use App\Areas;

class AreasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas = Areas::all();
        return view('areas', ['areas' => $areas]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('new_area');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AreaRequest $request)
    {
        $areas = new Areas();
        $areas->area_en = $request->input('area_en');
        $areas->area_ar = $request->input('area_ar');
        $areas->save();
        return redirect('/areas');
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
        $area = Areas::find($id);
        return view('area_edit', ['area' => $area]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AreaRequest $request, $id)
    {
        $area = Areas::find($id);
        $area->area_en = $request->input('area_en');
        $area->area_ar = $request->input('area_ar');
        $area->save();
        return redirect('/areas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteAreas(Request $request)
    {
        $id = $request->get('id');
        Areas::whereIn('id',$id)->delete();


        return redirect('/areas');
    }
}
