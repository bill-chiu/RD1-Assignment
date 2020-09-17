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
                //篩選早晚6:00以及明後天的資料
                $date = date("Y-m-d");
                // $sql = <<<multi
                // select * from sevenDay WHERE `startTime` > '$date%' 
        $data = TodayModel::all();
        $data2 = TwoDayModel::where('startTime','LIKE','%6:00%')->orWhere('startTime','LIKE','%18:00%')->where('startTime','LIKE',"$date1")->orWhere('startTime','LIKE',"$date2")->get();
        $data3 = SevenDayModel::where('startTime','>',"$date")->get();

        
        return view('index', compact('data','data2','data3'));

        
    }


    public function weather_fetch(){


        

    }
}
