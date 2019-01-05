<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\RestaurantCategory;
use App\Restaurant;
use Illuminate\Support\Facades\File;
use Auth;

class RestaurantCategoriesController extends Controller
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
            $categories = RestaurantCategory::paginate(20);
            $data = $request->all();
            if (isset($data['restaurant_category_search'])) {
                $categories = RestaurantCategory::where('name_en', 'like', '%' . $data['restaurant_category_search'] . '%')
                    ->orWhere('name_ar', 'like', '%' . $data['restaurant_category_search'] . '%')->paginate(20);
            }
            return view('restaurant_categories', ['categories' => $categories]);
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
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $request->validate([
                'name_en' => 'required|string|max:255',
                'name_ar' => 'required|string|max:255|'
            ]);
            $category = new RestaurantCategory();
            $category->name_en = $request->input('name_en');
            $category->name_ar = $request->input('name_ar');
            $category->save();
            if ($category) {
                return redirect('/restaurant_categories');
            }
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
            $request->validate([
                'name_en' => 'required|string|max:255',
                'name_ar' => 'required|string|max:255|'
            ]);
            $category = RestaurantCategory::find($id);
            $category->name_en = $request->input('name_en');
            $category->name_ar = $request->input('name_ar');
            $category->save();
            return redirect('/restaurant_categories');
        } else {
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteRestaurantCategory(Request $request)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $id = $request->get('id');
            RestaurantCategory::whereIn('id', $id)->delete();
            return redirect('/restaurant_categories');
        } else {
            return redirect()->back();
        }
    }

    public function getCategories(Request $request)
    {
        $lang = $request->header('Accept-Language');
        $device = $request->header('Device-Type');
        $version = $request->header('Version-Number');
        $req_auth = $request->header('Authorization');
        $user_id = User::getUserByToken($req_auth);
        if ($user_id) {
          User::where('id', $user_id)->update(['device_type' => $device, 'version_number' => $version]);
        }
        $categories = RestaurantCategory::all();
        foreach ($categories as $category) {
            if ($lang == 'ar') {
                $name = $category->name_ar;
            } else {
                $name = $category->name_en;
            }
            $arr [] = [
                'category_id' => $category->id,
                'category_name' => $name,
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
