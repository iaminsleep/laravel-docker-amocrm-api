<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $deals = Deal::all();
        return view('index', ['deals' => $deals]);
    }
}
