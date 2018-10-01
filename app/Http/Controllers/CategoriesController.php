<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use Auth;
use Illuminate\Http\Request;
use App\Category;
use App\Menu;
use Illuminate\Support\Facades\File;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::paginate(20);
        $data = $request->all();
        if (isset($data['category_status'])) {
            $categories = Category::where('status', $data['category_status'])->paginate(20);
        }
        if (isset($data['category_search'])) {
            $categories = Category::where('name', 'like', $data['category_search'])
                ->orWhere('description', 'like', $data['category_search'])->paginate(20);
        }
        return view('menu_categories', ['categories' => $categories]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            return view('menu_category_create');
        } else {
            return redirect('/categories');
        }
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
                'description_en' => 'required|string',
                'name_ar' => 'required|string|max:255',
                'description_ar' => 'required|string',
            ]);
            $category = new Category();
            $category->name_en = $request->input('name_en');
            $category->description_en = $request->input('description_en');
            $category->name_ar = $request->input('name_ar');
            $category->description_ar = $request->input('description_ar');
            $category->status = $request->input('status');
            $category->save();
            if ($category) {
                return redirect('/categories');
            }
        } else {
            return redirect('/categories');
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
        if ($user->admin == 1) {
            $category = Category::find($id);
            return view('menu_category_edit', ['category' => $category]);
        } else {
            return redirect('/categories');
        }
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
                'description_en' => 'required|string',
                'name_ar' => 'required|string|max:255',
                'description_ar' => 'required|string',
            ]);
            $category = Category::find($id);
            $category->name_en = $request->input('name_en');
            $category->description_en = $request->input('description_en');
            $category->name_ar = $request->input('name_ar');
            $category->description_ar = $request->input('description_ar');
            $category->status = $request->input('status');
            $category->save();
            return redirect('/categories');
        } else {
            return redirect('/categories');
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
        if ($user->admin == 1) {
            $id = $request->get('id');
            $categories = Category::where('id', $id)->get();
            foreach ($categories as $category) {
                if ($category->menu) {
                    $menu_images = [];
                    foreach ($category->menu as $menu) {
                        $menu_images[] = public_path('images/' . $menu->menu_photo);
                    }

                    File::delete($menu_images);
                }
            }
            Category::whereIn('id', $id)->delete();
            return redirect('/categories');
        } else {
            return redirect('/categories');
        }

    }
}
