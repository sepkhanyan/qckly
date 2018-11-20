<?php

namespace App\Http\Controllers;

use App\Collection;
use App\CollectionMenu;
use Auth;
use Illuminate\Http\Request;
use App\MenuCategory;
use App\Menu;
use App\Restaurant;
use Illuminate\Support\Facades\File;

class MenuCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id = null)
    {
        $user = Auth::user();
        $restaurants = Restaurant::all();
        $selectedRestaurant = [];
        $data = $request->all();
        $categories = [];
        if ($id) {
            $categories = MenuCategory::where('restaurant_id', $id);
            if (isset($data['category_search'])) {
                $categories = $categories->name($data['category_search']);
            }
            $selectedRestaurant = Restaurant::find($id);
            $categories = $categories->paginate(20);
        }
        if ($user->admin == 2) {
            $user = $user->load('restaurant');
            $restaurant = $user->restaurant;
            $categories = MenuCategory::where('restaurant_id', $restaurant->id);
            if (isset($data['category_search'])) {
                $categories = $categories->name($data['category_search']);
            }
            $selectedRestaurant = Restaurant::find($restaurant->id);
            $categories = $categories->paginate(20);

        }
        return view('menu_categories', [
            'id' => $id,
            'restaurants' => $restaurants,
            'categories' => $categories,
            'selectedRestaurant' => $selectedRestaurant,
            'user' => $user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    {
        $user = Auth::user();
        $restaurant = Restaurant::where('id', $id)->first();
        if ($user->admin == 2) {
            $user = $user->load('restaurant');
            $restaurant = $user->restaurant;
        }
        return view('menu_category_create', [
            'restaurant' => $restaurant,
            'user' => $user
            ]);
    }

    /**
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'description_en' => 'required|string',
            'name_ar' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'image' => 'required|image'
        ]);
        $restaurant_id = $request->input('restaurant');
        $user = Auth::user();
        if ($user->admin == 2) {
            $user = $user->load('restaurant');
            $restaurant_id = $user->restaurant->id;
        }
        $category = new MenuCategory();
        $category->restaurant_id = $restaurant_id;
        $category->name_en = $request->input('name_en');
        $category->description_en = $request->input('description_en');
        $category->name_ar = $request->input('name_ar');
        $category->description_ar = $request->input('description_ar');
        $image = $request->file('image');
        $name = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $name);
        $category->image = $name;
        $category->save();
        if ($category) {
            return redirect('/menu_categories/' . $restaurant_id);
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
        $user = Auth::user();
        $category = MenuCategory::find($id);
        if ($user->admin == 2) {
            $user = $user->load('restaurant');
            $restaurant = $user->restaurant;
            $category = MenuCategory::where('id', $id)->where('restaurant_id', $restaurant->id)->first();
            if (!$category) {
                return redirect()->back();
            }
        }
        return view('menu_category_edit', [
            'category' => $category,
            'user' => $user
            ]);
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
        $request->validate([
            'name_en' => 'required|string|max:255',
            'description_en' => 'required|string',
            'name_ar' => 'required|string|max:255',
            'description_ar' => 'required|string',
        ]);
        $user = Auth::user();
        $category = MenuCategory::find($id);
        $restaurant_id = $request->input('restaurant');
        if ($user->admin == 2) {
            $user = $user->load('restaurant');
            $restaurant = $user->restaurant;
            $restaurant_id = $restaurant->id;
            $category = MenuCategory::where('id', $id)->where('restaurant_id', $restaurant->id)->first();
            if (!$category) {
                return redirect('/categories');
            }
        }
        $category->name_en = $request->input('name_en');
        $category->description_en = $request->input('description_en');
        $category->name_ar = $request->input('name_ar');
        $category->description_ar = $request->input('description_ar');
        if ($request->hasFile('image')) {
            if ($category->image) {
                File::delete(public_path('images/' . $category->image));
            }
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $category->image = $name;
        }
        $category->save();
        return redirect('/menu_categories/' . $restaurant_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteCategory(Request $request)
    {
        $id = $request->get('id');
        $categories = MenuCategory::where('id', $id)->get();
        $user = Auth::user();
        if ($user->admin == 2) {
            $user = $user->load('restaurant');
            $restaurant = $user->restaurant;
            $categories = MenuCategory::where('id', $id)->where('restaurant_id', $restaurant->id)->get();
            foreach ($categories as $category) {
                if ($category->menu) {
                    $menu_images = [];
                    foreach ($category->menu as $menu) {
                        $menu_images[] = public_path('images/' . $menu->image);
                    }
                    File::delete($menu_images);
                }
                $category_images[] = public_path('images/' . $category->image);
            }
            File::delete($category_images);
            MenuCategory::whereIn('id', $id)->where('restaurant_id', $restaurant->id)->delete();
        } else {
            foreach ($categories as $category) {
                if ($category->menu) {
                    $menu_images = [];
                    foreach ($category->menu as $menu) {
                        $menu_images[] = public_path('images/' . $menu->image);
                    }
                    File::delete($menu_images);
                }
                $category_images[] = public_path('images/' . $category->image);
            }
            File::delete($category_images);
            MenuCategory::whereIn('id', $id)->delete();
        }
        return redirect('/menu_categories');

    }
}
