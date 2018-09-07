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
        $categories = CollectionCategory::all();
        return view('collection_categories', ['categories' => $categories]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
        $user = Auth::user();
        if($user->admin == 1){
            $category = New CollectionCategory();
            $category->name_en = $request->input('category_en');
            $category->name_ar = $request->input('category_ar');
            $category->save();
            return redirect('/collection_categories');
        }else{
            return redirect('collection_categories');
        }

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
    public function edit($id)
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
        $user = Auth::user();
        if($user->admin == 1){
            $category = CollectionCategory::find($id);
            $category->name_en = $request->input('category_en');
            $category->name_ar = $request->input('category_ar');
            $category->save();
            return redirect('/collection_categories');
        }else{
            return redirect('collection_categories');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteCategory(Request $request)
    {
        $user = Auth::user();
        if($user->admin == 1){
            $id = $request->get('id');
            CollectionCategory::whereIn('id',$id)->delete();
            return redirect('/collection_categories');
        }else{
            return redirect('collection_categories');
        }


    }
}
