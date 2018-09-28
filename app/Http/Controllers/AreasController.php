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
                $areas = Area::where('area_en', 'like', $data['area_search'])
                    ->orWhere('area_ar', 'like', $data['area_search'])->paginate(20);
            }
            return view('areas', ['areas' => $areas]);
        } else {
            return redirect('/');
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
            $area->area_en = $request->input('area_en');
            $area->area_ar = $request->input('area_ar');
            $area->save();
            return redirect('/areas');
        } else {
            return redirect('/');
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
    public function update(AreaRequest $request, $id)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $area = Area::find($id);
            $area->area_en = $request->input('area_en');
            $area->area_ar = $request->input('area_ar');
            $area->save();
            return redirect('/areas');
        } else {
            return redirect('/');
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
            $areas = Area::with('restaurant')->where('id', $id)->get();
            foreach ($areas as $area) {
                if ($area->restaurant) {
                    $restaurant_images = [];
                    $menu_images = [];
                    foreach ($area->restaurant as $restaurant) {
                        foreach ($restaurant->menu as $menu) {
                            $menu_images[] = public_path('images/' . $menu->menu_photo);
                        }
                        $restaurant_images[] = public_path('images/' . $restaurant->restaurant_image);
                    }
                    File::delete($menu_images);
                    File::delete($restaurant_images);
                }
            }
            Area::where('id', $id)->delete();
            return redirect('/areas');
        } else {
            return redirect('/');
        }
    }


    public function getAreas(Request $request)
    {
        $lang = $request->header('Accept-Language');
        $areas = Area::all();
        foreach ($areas as $area) {
            if ($lang == 'ar') {
                $area_name = $area->area_ar;
            } else {
                $area_name = $area->area_en;
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
