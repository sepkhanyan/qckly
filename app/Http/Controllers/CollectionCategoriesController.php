<?php

namespace App\Http\Controllers;

use App\CollectionCategory;
use Illuminate\Http\Request;
use Auth;


class CollectionCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $categories = CollectionCategory::all();
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


    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $request->validate([
                'name_en' => 'required|string|max:255',
                'name_ar' => 'required|string|max:255'
            ]);
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
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $request->validate([
                'name_en' => 'required|string|max:255',
                'name_ar' => 'required|string|max:255'
            ]);
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
