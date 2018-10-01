<?php

namespace App\Http\Controllers;

use App\Mealtime;
use Illuminate\Http\Request;
use Auth;

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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $mealtime = new Mealtime();
            $mealtime->name_en = $request->input('mealtime_en');
            $mealtime->name_ar = $request->input('mealtime_ar');
            $mealtime->start_time = $request->input('start_time');
            $mealtime->end_time = $request->input('end_time');
            $mealtime->save();
            return redirect('/mealtimes');
        } else {
            return redirect('/mealtimes');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $mealtime = Mealtime::find($id);
            $mealtime->name_en = $request->input('mealtime_en');
            $mealtime->name_ar = $request->input('mealtime_ar');
            $mealtime->start_time = $request->input('start_time');
            $mealtime->end_time = $request->input('end_time');
            $mealtime->save();
            return redirect('/mealtimes');
        } else {
            return redirect('/mealtimes');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteMealtime(Request $request)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $id = $request->get('id');
            $mealtimes = Mealtime::where('id', $id)->get();
            foreach ($mealtimes as $mealtime) {
                if ($mealtime->menu) {
                    $menu_images = [];
                    foreach ($mealtime->menu as $menu) {
                        $menu_images[] = public_path('images/' . $menu->menu_photo);
                    }

                    File::delete($menu_images);
                }
            }
            Mealtime::whereIn('id', $id)->delete();
            return redirect('/mealtimes');
        } else {
            return redirect('/mealtimes');
        }
    }
}
