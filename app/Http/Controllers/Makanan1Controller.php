<?php

namespace App\Http\Controllers;

use App\Models\Master\MasterMakanan;
use Illuminate\Http\Request;

class Makanan1Controller extends Controller
{
    public function index(MasterMakanan $makanan)
    {
        $makanan = $makanan::all();
        dd($makanan);
    }
}
