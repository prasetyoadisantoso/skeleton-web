<?php

namespace App\Http\Controllers\Testing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        return view('testing.test');
    }

    public function create()
    {
        return view('testing.test');
    }


    public function edit(Request $request,$id)
    {
        return view('testing.test');
    }

}
