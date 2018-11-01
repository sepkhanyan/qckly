<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\NewMessage;
use Auth;

class TestController extends Controller
{
    public function index()
    {
        return view('test');
    }

    public function sender()
    {
        return view('sender');
    }

    public function test(Request $request)
    {
        event(new NewMessage(Auth::user(), $request->get('message')));
    }
}
