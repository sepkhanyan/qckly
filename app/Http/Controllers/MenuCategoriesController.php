<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuCategoryRequest;
use App\Collection;
use App\CollectionMenu;
use App\EditingMenuCategory;
use Auth;
use Illuminate\Http\Request;
use App\MenuCategory;
use App\Menu;
use App\Restaurant;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
        $data = $request->all();

        if ($user->admin == 1) {

            $restaurants = Restaurant::where('deleted', 0)->get();

            if ($id) {

                $categories = MenuCategory::where('restaurant_id', $id)->where('deleted', 0)->with('editingMenuCategory');
                if (isset($data['category_search'])) {
                    $categories = $categories->name($data['category_search']);
                }
                $selectedRestaurant = Restaurant::find($id);
                $categories = $categories->orderby('approved', 'asc')->paginate(20);
            }

        }

        elseif($user->admin == 2) {

            $categories = MenuCategory::where('restaurant_id', $user->restaurant_id)->where('deleted', 0)->with('editingMenuCategory');

            if (isset($data['category_search'])) {
                $categories = $categories->name($data['category_search']);
            }

            $selectedRestaurant = Restaurant::find($user->restaurant_id);
            $categories = $categories->orderby('approved', 'asc')->paginate(20);

        }
        return view('menus.menu_categories', [
            'id' => $id,
            'categories' => isset($categories) ? $categories : collect(),
            'restaurants' => isset($restaurants) ? $restaurants : "",
            'selectedRestaurant' => isset($selectedRestaurant) ? $selectedRestaurant : "",
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
            $restaurant = Restaurant::where('id', $user->restaurant_id)->first();
        }
        return view('menus.menu_category_create', [
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
    public function store(MenuCategoryRequest $request)
    {
        $restaurant_id = $request->input('restaurant');
        $user = Auth::user();
        if ($user->admin == 2) {
            $restaurant_id = $user->restaurant_id;
        }
        $category = new MenuCategory();
        $category->restaurant_id = $restaurant_id;
        $category->name_en = $request->input('name_en');
        $category->description_en = $request->input('description_en');
        $category->name_ar = $request->input('name_ar');
        $category->description_ar = $request->input('description_ar');
        $image = $request->file('image');
        $name = 'category_' . time() . '.' . $image->getClientOriginalExtension();
        $path = public_path('/images');
        $image->move($path, $name);
        $category->image =  $name;
        if($user->admin == 1){
            $category->approved = 1;
        }
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
    public function approve($id)
    {
        $user = Auth::user();
        if($user->admin ==1){
            MenuCategory::where('id', $id)->update(['approved' => 1]);
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }

    public function reject($id)
    {
        $user = Auth::user();
        if($user->admin ==1){
            MenuCategory::where('id', $id)->update(['approved' => 2]);
            return redirect()->back();
        }else{
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
        $user = Auth::user();
        $category = MenuCategory::find($id);
        if ($user->admin == 2) {
            $category = MenuCategory::where('id', $id)->where('restaurant_id', $user->restaurant_id)->first();
            if (!$category) {
                return redirect()->back();
            }
        }
        if($user->admin == 1 && $category->editingMenuCategory !== null){
            $editingMenuCategory = $category->editingMenuCategory;
            return view('menu_category_edit_approve', [
                'category' => $category,
                'editingMenuCategory' => $editingMenuCategory,
                'user' => $user
            ]);
        }
        return view('menus.menu_category_edit', [
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
    public function update(MenuCategoryRequest $request, $id)
    {
        $user = Auth::user();
        $category = MenuCategory::find($id);
        $restaurant_id = $request->input('restaurant');
        if ($user->admin == 2) {
            $category = MenuCategory::where('id', $id)->where('restaurant_id', $user->restaurant_id)->first();
            if (!$category) {
                return redirect('/menu_categories');
            }
            EditingMenuCategory::where('category_id', $category->id)->delete();
            $editingCategory = new EditingMenuCategory();
            $editingCategory->category_id = $category->id;
            $editingCategory->name_en = $request->input('name_en');
            $editingCategory->description_en = $request->input('description_en');
            $editingCategory->name_ar = $request->input('name_ar');
            $editingCategory->description_ar = $request->input('description_ar');
            if ($request->hasFile('image')){
                $image = $request->file('image');
                $name = 'category_' . time() . '.' . $image->getClientOriginalExtension();
                $path = public_path('/images');
                $image->move($path, $name);
                $editingCategory->image =  $name;
            }
            $editingCategory->save();
            return redirect('/menu_categories');
        }elseif ($user->admin == 1){
            $category->name_en = $request->input('name_en');
            $category->description_en = $request->input('description_en');
            $category->name_ar = $request->input('name_ar');
            $category->description_ar = $request->input('description_ar');
            if ($request->hasFile('image')) {
                if ($category->image) {
                    File::delete(public_path('images/' . $category->image));
                }
                $image = $request->file('image');
                $name = 'category_' . time() . '.' . $image->getClientOriginalExtension();
                $path = public_path('/images');
                $image->move($path, $name);
                $category->image =  $name;
            }
            $category->approved = 1;
            $category->save();
            EditingMenuCategory::where('category_id', $category->id)->delete();
        }
        return redirect('/menu_categories/' . $restaurant_id);
    }


    public function editApprove(MenuCategoryRequest $request, $id)
    {
        $user = Auth::user();
        if($user->admin ==1){
            $category = MenuCategory::find($id);
            $editingMenuCategory = EditingMenuCategory::where('category_id', $id)->first();
            $restaurant_id = $request->input('restaurant');
            $category->name_en = $request->input('name_en');
            $category->description_en = $request->input('description_en');
            $category->name_ar = $request->input('name_ar');
            $category->description_ar = $request->input('description_ar');
            if ($editingMenuCategory->image) {
                if ($category->image) {
                    File::delete(public_path('images/' . $category->image));
                }
                $category->image =  $editingMenuCategory->image;
            }
            $category->approved = 1;
            $category->save();
            EditingMenuCategory::where('category_id', $category->id)->delete();
            return redirect('/menu_categories/' . $restaurant_id);
        }else{
            return redirect()->back();
        }
    }

    public function editReject($id)
    {
        $user = Auth::user();
        if($user->admin ==1){
            $editingMenuCategories = EditingMenuCategory::where('category_id', $id)->get();
            $category = MenuCategory::find($id);
            $category_images = [];
            foreach ($editingMenuCategories as $editingMenuCategory){
                $category_images[] = public_path('images/' . $editingMenuCategory->image);
            }
            File::delete($category_images);
            EditingMenuCategory::where('category_id', $id)->delete();
            return redirect('/menu_categories/' . $category->restaurant_id);
        }else{
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteCategory(Request $request)
    {
        $user = Auth::user();
        $id = $request->get('id');
        $menuCategory = MenuCategory::where('id', $id)->first();
        if ($user->admin == 2) {
            if($menuCategory->restaurant_id == $user->restaurant_id){
                MenuCategory::whereIn('id', $id)->update(['deleted' => 1]);
            }else{
                return redirect()->back();
            }
        }elseif($user->admin == 1){
            MenuCategory::whereIn('id', $id)->update(['deleted' => 1]);
        }
        return redirect('/menu_categories');

    }
}
