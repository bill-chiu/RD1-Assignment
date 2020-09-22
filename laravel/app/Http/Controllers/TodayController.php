<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TodayModel;
use App\TwoDayModel;
use App\SevenDayModel;
use App\RainModel;
use DB;

class TodayController extends Controller
{
    public function newData(Request $request)
    {
        $locationName = $request->input('locationName');
        switch ($request->submitbutton) {
            case '查詢天氣':
                

                $date1 = date("Y-m-d", strtotime("1 day"));
                $date2 = date("Y-m-d", strtotime("2 day"));                                              
        
                $data = TodayModel::where('City',"$locationName")->get();
                
                $data2 = TwoDayModel::where('startTime','LIKE',"%$date1%")->where('City',"$locationName")     
                ->where(function($query)
                {
                $query
                ->where('startTime','LIKE','%6:00%')
                ->orWhere('startTime','LIKE','%18:00%');
            })
               ->orWhere('startTime','LIKE',"%$date2%")->where('City',"$locationName")
               ->where(function($query)
            {
                $query
              ->where('startTime','LIKE','%6:00%')
              ->orWhere('startTime','LIKE','%18:00%');
        })->get();                                              
                $data3 = SevenDayModel::where('startTime','>',"$date1")->where('City',"$locationName")->get();
        
                $data4=TwoDayModel::where('City',"$locationName")->get();
              
                return view('index', compact('data','data2','data3','data4','locationName'));
                break;
    
            case '查詢雨量':
             

                $data5=RainModel::where('city',"$locationName")->orderBy('town', 'ASC')->get();
      
                return view('rain', compact('locationName','data5'));
                break;
    }
    }


    public function index($locationName='基隆市')
    {

        //記錄明天後天的日期
        $date1 = date("Y-m-d", strtotime("1 day"));
        $date2 = date("Y-m-d", strtotime("2 day"));                                              

        $data = TodayModel::where('City',"$locationName")->get();
        
        $data2 = TwoDayModel::where('startTime','LIKE',"%$date1%")->where('City',"$locationName")     
                                ->where(function($query)
                                {
                                $query
                                ->where('startTime','LIKE','%6:00%')
                                ->orWhere('startTime','LIKE','%18:00%');
                            })
                               ->orWhere('startTime','LIKE',"%$date2%")->where('City',"$locationName")
                               ->where(function($query)
                            {
                                $query
                              ->where('startTime','LIKE','%6:00%')
                              ->orWhere('startTime','LIKE','%18:00%');
                        })->get();                           
        $data3 = SevenDayModel::where('startTime','>',"$date1")->where('City',"$locationName")->get();

        $data4=TwoDayModel::where('City',"$locationName")->get();
      
        return view('index', compact('data','data2','data3','data4','locationName'));

        
    }
}