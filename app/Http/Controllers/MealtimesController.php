<?php

namespace App\Http\Controllers;

use App\Mealtime;
use Illuminate\Http\Request;

class MealtimesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mealtimes = Mealtime::all();
        return view('mealtimes', ['mealtimes' => $mealtimes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
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
        $mealtime = new Mealtime();
        $mealtime->name_en = $request->input('mealtime_en');
        $mealtime->name_ar = $request->input('mealtime_ar');
        $mealtime->start_time = $request->input('start_time');
        $mealtime->end_time = $request->input('end_time');
        $mealtime->save();
        return redirect('/mealtimes');
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
    public function edit(Request $request)
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
        $mealtime = Mealtime::find($id);
        $mealtime->name_en = $request->input('mealtime_en');
        $mealtime->name_ar = $request->input('mealtime_ar');
        $mealtime->start_time = $request->input('start_time');
        $mealtime->end_time = $request->input('end_time');
        $mealtime->save();
        return redirect('/mealtimes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteMealtimes(Request $request)
    {
        $id = $request->get('id');
        Mealtime::whereIn('id',$id)->delete();
        return redirect('/mealtimes');
    }
}
