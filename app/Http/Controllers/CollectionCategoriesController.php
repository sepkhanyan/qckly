<?php

namespace App\Http\Controllers;

use App\CollectionCategory;
use App\Http\Requests\CollectionCategoryRequest;
use Illuminate\Http\Request;
use Auth;


class CollectionCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $categories = CollectionCategory::all();
        $data = $request->all();
        if (isset($data['collection_category_search'])) {
            $categories = $categories->where('name_en', 'like', '%' . $data['collection_category_search'] . '%');
        }
        return view('collection_categories', [
            'categories' => $categories,
            'user' => $user
            ]);
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


    public function store(CollectionCategoryRequest $request)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $category = New CollectionCategory();
            $category->name_en = $request->input('name_en');
            $category->name_ar = $request->input('name_ar');
            $category->save();
            return redirect('/collection_categories');
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
    public function update(CollectionCategoryRequest $request, $id)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $category = CollectionCategory::find($id);
            $category->name_en = $request->input('name_en');
            $category->name_ar = $request->input('name_ar');
            $category->save();
            return redirect('/collection_categories');
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
    public function deleteCategory(Request $request)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $id = $request->get('id');
            CollectionCategory::whereIn('id', $id)->delete();
            return redirect('/collection_categories');
        } else {
            return redirect()->back();
        }


    }
}
