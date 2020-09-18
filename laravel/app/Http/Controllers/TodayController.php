<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TodayModel;
use App\TwoDayModel;
use App\SevenDayModel;

class TodayController extends Controller
{
    public function index()
    {
        //記錄明天後天的日期
        $date1 = date("Y-m-d", strtotime("1 day"));
        $date2 = date("Y-m-d", strtotime("2 day"));                                              

        $data = TodayModel::all();
        
        $data2 = TwoDayModel::where('startTime','LIKE',"%$date1%")      
                                ->where(function($query)
                                {
                                $query->where('startTime','LIKE','%6:00%')
                                ->orWhere('startTime','LIKE','%18:00%');
                            })
                               ->orwhere('startTime','LIKE',"%$date2%")      
                               ->where(function($query)
                            {
                              $query->where('startTime','LIKE','%6:00%')
                              ->orWhere('startTime','LIKE','%18:00%');
                        })->get();                           
        $data3 = SevenDayModel::where('startTime','>',"$date1")->get();

        $data4=TwoDayModel::all();
      
        return view('index', compact('data','data2','data3','data4'));

        
    }
}