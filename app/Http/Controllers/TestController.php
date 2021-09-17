<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index(Request $req)
    {
        $test = DB::table('t_wfawfo_d')->where('no_tran', '=' ,'2105240001')->get();
        dd($test);
    }
}
