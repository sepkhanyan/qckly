<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use Auth;
use Illuminate\Http\Request;
use App\Categories;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
            $categories = Categories::paginate(15);
        $data = $request->all();
        if(isset($data['category_status'])){
            $categories = Categories::where('status',$data['category_status'])->paginate(15);
        }
        if(isset($data['category_search'])){
            $categories = Categories::where('name','like',$data['category_search'])
                ->orWhere('status','like',$data['category_search'])
                ->orWhere('description','like',$data['category_search'])->paginate(15);
        }
            return view('categories', ['categories' => $categories]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('new_category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)

    {
        $categories = new Categories();
        $categories->name = $request->input('name');
        $categories->parent_id = $request->input('parent_id');
        $categories->description = $request->input('description');
        $categories->status = $request->input('status');
        $categories->priority = $request->input('priority');
        $categories->save();
        if ($categories) {
            return redirect('/categories');
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
        $category = Categories::find($id);
        return view('category_edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = Categories::find($id);
        $category->name = $request->input('name');
        $category->parent_id = $request->input('parent_id');
        $category->description = $request->input('description');
        $category->status = $request->input('status');
        $category->priority = $request->input('priority');
        $category->save();
        return redirect('/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteCategories(Request $request)
    {
        $id = $request->get('id');
        Categories::whereIn('category_id',$id)->delete();


        return redirect('/categories');
    }
}
