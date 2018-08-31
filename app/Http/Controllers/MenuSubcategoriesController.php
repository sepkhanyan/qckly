<?php

namespace App\Http\Controllers;

use App\MenuSubcategory;
use Illuminate\Http\Request;


class MenuSubcategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = MenuSubcategory::all();
        return view('menu_subcategories', ['subcategories' => $subcategories]);
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
        $subcategory = New MenuSubcategory();
        $subcategory->name_en = $request->input('subcategory_en');
        $subcategory->name_ar = $request->input('subcategory_ar');
        $subcategory->save();
        return redirect('/menu_subcategories');
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
        $subcategory = MenuSubcategory::find($id);
        return view('menu_subcategory_edit', ['subcategory' => $subcategory]);
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
        $subcategory = MenuSubcategory::find($id);
        $subcategory->name_en = $request->input('subcategory_en');
        $subcategory->name_ar = $request->input('subcategory_ar');
        $subcategory->save();
        return redirect('/menu_subcategories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteSubcategory(Request $request)
    {
        $id = $request->get('id');
        MenuSubcategory::whereIn('id',$id)->delete();
        return redirect('/menu_subcategories');

    }
}
