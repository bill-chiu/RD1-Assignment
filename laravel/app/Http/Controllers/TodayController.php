<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TodayModel;

class TodayController extends Controller
{
    public function index()
    {
        $data = TodayModel::all();

        return view('index', compact('data'));
        
    }
}
