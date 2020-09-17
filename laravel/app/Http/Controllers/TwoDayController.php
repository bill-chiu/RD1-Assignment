<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TwoDayModel;

class TwoDayController extends Controller
{
    public function index()
    {
        $data2 = TwoDayModel::all();

        return view('index', compact('data2'));
        
    }
}
