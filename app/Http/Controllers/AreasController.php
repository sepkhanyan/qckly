<?php

namespace App\Http\Controllers;

use App\Http\Requests\AreaRequest;
use Auth;
use Illuminate\Http\Request;
use App\Area;
use App\Restaurant;
use Illuminate\Support\Facades\File;

class AreasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $areas = Area::paginate(20);
            $data = $request->all();

            if (isset($data['area_search'])) {
                $areas = Area::where('name_en', 'like', '%' . $data['area_search'] . '%' )->paginate(20);
            }
            return view('areas', [
                'areas' => $areas,
                'user' => $user
            ]);
        } else {
            return redirect()->back();
        }


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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AreaRequest $request)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $area = new Area();
            $area->name_en = $request->input('name_en');
            $area->name_ar = $request->input('name_ar');
            $area->save();
            return redirect('/areas');
        } else {
            return redirect()->back();
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AreaRequest $request)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $id = $request->id;
            $area = Area::find($id);
            $area->name_en = $request->name_en;
            $area->name_ar = $request->name_ar;
            $area->save();

            return redirect('/areas');
        } else {
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteArea(Request $request)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $id = $request->get('id');
            Area::whereIn('id', $id)->delete();
            return redirect('/areas');
        } else {
            return redirect()->back();
        }
    }


    public function getAreas(Request $request)
    {
//        \Log::info($request->all());
        $lang = $request->header('Accept-Language');
        $areas = Area::all();
        foreach ($areas as $area) {
            if ($lang == 'ar') {
                $area_name = $area->name_ar;
            } else {
                $area_name = $area->name_en;
            }
            $arr [] = [
                'area_id' => $area->id,
                'area' => $area_name,
            ];
        }
        if ($arr) {
            return response()->json(array(
                'success' => 1,
                'status_code' => 200,
                'data' => $arr));
        }
    }
}
