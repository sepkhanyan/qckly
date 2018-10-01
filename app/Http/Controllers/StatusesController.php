<?php

namespace App\Http\Controllers;

use App\Status;
use Illuminate\Http\Request;
use Auth;

class StatusesController extends Controller
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
            $statuses = Status::paginate(20);
            $data = $request->all();

            if (isset($data['status_search'])) {
                $statuses = Status::where('name_en', 'like', $data['status_search'])
                    ->orWhere('name_ar', 'like', $data['status_search'])->paginate(20);
            }
            return view('statuses', ['statuses' => $statuses]);
        } else {
            return redirect('/');
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
                'name_ar' => 'required|string|max:255|',
            ]);
            $status = new Status();
            $status->name_en = $request->input('name_en');
            $status->name_ar = $request->input('name_ar');
            $status->save();
            return redirect('/statuses');
        } else {
            return redirect('/');
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
                'name_ar' => 'required|string|max:255|',
            ]);
            $status = Status::find($id);
            $status->name_en = $request->input('name_en');
            $status->name_ar = $request->input('name_ar');
            $status->save();
            return redirect('/statuses');
        } else {
            return redirect('/');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteStatus(Request $request)
    {
        $user = Auth::user();
        if ($user->admin == 1) {
            $id = $request->get('id');
            Status::whereIn('id', $id)->delete();
            return redirect('/statuses');
        } else {
            return redirect('/');
        }
    }
}
