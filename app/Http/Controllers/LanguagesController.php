<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\File;

class LanguagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if($user->admin == 1){
            $languages = Language::paginate(20);
            $data = $request->all();

            if (isset($data['language_search'])) {
                $languages = Language::where('name', 'like', $data['language_search'])->paginate(20);
            }
            return view('languages', ['languages' => $languages ]);
        }else{
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
        $user = Auth::user();
        if ($user->admin == 1) {
            return view('language_create');
        } else {
            return redirect('/languages');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->input('image'));
        $user = Auth::user();
        if ($user->admin == 1) {
            $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string',
                'idiom' => 'required|string|max:255',
                'image' => 'required|image',
            ]);
            $language = new Language();
            $language->name = $request->input('name');
            $language->code = $request->input('code');
            $flag = $request->file('image');
            $name = $flag->getClientOriginalName();
            $destinationPath = public_path('/images');
            $flag->move($destinationPath, $name);
            $language->image = $name;
            $language->idiom = $request->input('idiom');
            $language->save();
            return redirect('/languages');
        }else{
            return redirect('/languages');
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
        $user = Auth::user();
        if ($user->admin == 1) {
            $language = Language::find($id);
            return view('language_edit', ['language' => $language]);
        }else{
            return redirect('/languages');
        }
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
        if ($user->admin == 1) {
            $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string',
                'idiom' => 'required|string|max:255',
            ]);
            $language = Language::find($id);
            $language->name = $request->input('name');
            $language->code = $request->input('code');
            $language->idiom = $request->input('idiom');
            if ($request->hasFile('image')) {
                if ($language->image) {
                    File::delete(public_path('images/' . $language->image));
                }
                $flag = $request->file('image');
                $name = $flag->getClientOriginalName();
                $destinationPath = public_path('/images');
                $flag->move($destinationPath, $name);
                $language->image = $name;
            }
            $language->save();
            return redirect('/languages');
        }else{
            return redirect('/languages');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteLanguage(Request $request)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $id = $request->get('id');
            $languages = Language::where('id', $id)->get();
            $images = [];
            foreach ($languages as $language) {
                $images[] = public_path('images/' . $language->image);
            }
            File::delete($images);
            Language::whereIn('id', $id)->delete();
            return redirect('/languages');
        }else{
            return redirect('/languages');
        }
    }
}
