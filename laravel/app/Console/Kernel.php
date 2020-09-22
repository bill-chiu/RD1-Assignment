<?php

namespace App\Console;

use DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * 应用提供的 Artisan 命令
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     *定义应用的命令调度
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $Authorization = 'CWB-1B75C5B5-3E1B-4775-96B4-7FA1A26DF256';
            $this->newTodayData($Authorization);
            $this->newTowdayData($Authorization);
            $this->newSevendayData($Authorization);
            $this->rain();
        })->everyTenMinutes();
    }

  public function newTodayData($Authorization)
    {
        DB::table('today')->delete();

        $url = ("https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=".$Authorization);
        $json = file_get_contents($url);
        $data = json_decode($json, true);
        $i=0;
        while ($i < count($data['records']['location'])) {

        $city= $data['records']['location'][$i]['locationName'];
        //取得天氣因子
        $weatherElement = $data['records']['location'][$i]['weatherElement'];
        
        //天氣現象描述
        $Wx=$weatherElement[0]['time'][0]['parameter']["parameterName"];
        //天氣圖片vaiue
        $WxV=$weatherElement[0]['time'][0]['parameter']["parameterValue"];
        //降雨機率
        $PoP=$weatherElement[1]['time'][0]['parameter']["parameterName"];
        //最高跟最低溫
        $MinT=$weatherElement[2]['time'][0]['parameter']["parameterName"];
        $MaxT=$weatherElement[4]['time'][0]['parameter']["parameterName"];
        
        //將儲存資料加入至資料庫
        
        DB::table('today')->insert([
            'City'=>$city,
            'Wx'=>$Wx,
            'WxV'=>$WxV,
            'MaxT'=>$MaxT,
            'MinT'=>$MinT,
            'PoP'=>$PoP
            
        ]);
    $i++;
    }
    }
        public function newTowdayData($Authorization)
    {
        DB::table('twoDay')->delete();

        $url = ("https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=" . $Authorization);

        $json = file_get_contents($url);
        $data = json_decode($json, true);

     $k=0;
     while($k<count($data['records']['locations'][0]['location'])){
         
        $weatherElement = $data['records']['locations'][0]['location'][$k]['weatherElement'];
        $city=$data['records']['locations'][0]['location'][$k]['locationName'];
        $i = 0;
        while ($i < count($weatherElement[3]['time'])) {

            $startTime = $weatherElement[3]['time'][$i]['dataTime'];
        
            for ($j = 0; $j < count($weatherElement); $j++) {
                //用switch去對應所要記錄的內容
                switch ($weatherElement[$j]['elementName']) {
        
                    case "Wx":
                        $Wx = $weatherElement[$j]['time'][$i]['elementValue'][0]["value"];
                        $WxV = $weatherElement[$j]['time'][$i]['elementValue'][1]["value"];
                        break;
                    case "AT":
                        $AT = $weatherElement[$j]['time'][$i]['elementValue'][0]["value"];
                        break;
                    case "T":
                        $T = $weatherElement[$j]['time'][$i]['elementValue'][0]["value"];
                        break;
                    case "RH":
                        $RH = $weatherElement[$j]['time'][$i]['elementValue'][0]["value"];
                        break;
                    case "WS":
                        $WS = $weatherElement[$j]['time'][$i]['elementValue'][0]["value"];
                        break;
                    case "WeatherDescription":
                        $WeatherDescription = explode("。", $weatherElement[6]['time'][$i]['elementValue'][0]["value"]);
                        if (count($WeatherDescription) >= 7) {
                            if ($WeatherDescription[1] == "降雨機率  %") {
                                $PoP = "暫無數據";
                            } else {
                                $PoP = $WeatherDescription[1];
                            }
                            $Description = $WeatherDescription[3];
                        }
                        break;
                    case "WD":
                        $WD = $weatherElement[$j]['time'][$i]['elementValue'][0]["value"];
                        break;
                    default:
                }
            }
                //將儲存資料加入至資料庫
        
                DB::table('twoDay')->insert([
                    'City'=>$city,
                    'startTime'=>$startTime,
                    'Wx'=>$Wx,
                    'WxV'=>$WxV,
                    'T'=>$T,
                    'RH'=>$RH,
                    'PoP'=>$PoP,
                    'Description'=>$Description,
                    'WS'=>$WS,
                    'WD'=>$WD,
                ]);
               
$i++;
        }
     $k++;
    }
       
    }
    public function newSevendayData($Authorization)
    {
        DB::table('sevenDay')->delete();

        $url = ("https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=" . $Authorization);

        $json = file_get_contents($url);
        $data = json_decode($json, true);
        

        //取得天氣因子
        $k=0;
        while($k<count($data['records']['locations'][0]['location'])){
        $weatherElement = $data['records']['locations'][0]['location'][$k]['weatherElement'];
        $city=$data['records']['locations'][0]['location'][$k]['locationName'];
        $i = 0;
        while ($i < count($weatherElement[3]['time'])) {
            $startTime = $weatherElement[2]['time'][$i]['startTime'];
            for ($j = 0; $j < count($weatherElement); $j++) {
                //用switch去對應所要記錄的內容
                switch ($weatherElement[$j]['elementName']) {
                    case "Wx":
                        $Wx = $weatherElement[$j]['time'][$i]['elementValue'][0]["value"];
                        $WxV = $weatherElement[$j]['time'][$i]['elementValue'][1]["value"];
                        break;
                    case "MaxAT":
                        $MaxAT = $weatherElement[$j]['time'][$i]['elementValue'][0]["value"];
                        break;
                    case "MinAT":
                        $MinAT = $weatherElement[$j]['time'][$i]['elementValue'][0]["value"];
                        break;
                    case "T":
                        $T = $weatherElement[$j]['time'][$i]['elementValue'][0]["value"];
                        break;
                    case "MaxT":
                        $MaxT = $weatherElement[$j]['time'][$i]['elementValue'][0]["value"];
                        break;
                    case "MinT":
                        $MinT = $weatherElement[$j]['time'][$i]['elementValue'][0]["value"];
                        break;
        
                    case "RH":
                        $RH = $weatherElement[$j]['time'][$i]['elementValue'][0]["value"];
                        break;
                    case "WS":
                        $WS = $weatherElement[$j]['time'][$i]['elementValue'][0]["value"];
                        break;
                    case "WD":
                        $WD = $weatherElement[$j]['time'][$i]['elementValue'][0]["value"];
                        break;
                    default:
                }
            }
            //用句號切開秒數句並記錄需要的內容
            $WeatherDescription = explode("。", $weatherElement[10]['time'][$i]['elementValue'][0]["value"]);
        
            if (count($WeatherDescription) >= 7) {
                $PoP = $WeatherDescription[1];
                $Description = $WeatherDescription[3];
            } else
                $PoP = '';
            $Description = $WeatherDescription[2];
                //將儲存資料加入至資料庫
        
                DB::table('sevenDay')->insert([
                    'City'=>$city,
                    'startTime'=>$startTime,
                    'Wx'=>$Wx,
                    'WxV'=>$WxV,
                    'MaxAT'=>$MaxAT,
                    'MinAT'=>$MinAT,
                    'MaxT'=>$MaxT,
                    'MinT'=>$MinT,
                    'PoP'=>$PoP,
                    'Description'=>$Description,
                    'WS'=>$WS,
                    'WD'=>$WD,
                ]);

$i++;
        }
        $k++;
    }
    }
    public function rain()
{
    DB::table('rain')->delete();
    $url = ("https://opendata.cwb.gov.tw/api/v1/rest/datastore/O-A0002-001?Authorization=CWB-1B75C5B5-3E1B-4775-96B4-7FA1A26DF256&elementName=RAIN,HOUR_24,NOW&parameterName=TOWN,CITY,ATTRIBUTE");

$json = file_get_contents($url);
$data = json_decode($json, true);
//取得天氣因子
$location = $data['records']['location'];
$i = 0;
while ($i < count($location)) {
    //縣市
    $city = $location[$i]['parameter'][0]['parameterValue'];
    //鄉鎮
    $town = $location[$i]['parameter'][1]['parameterValue'];
    //觀測站名稱
    $townName = $location[$i]['locationName'];
    //觀測站所屬
    $attribute = $location[$i]['parameter'][2]['parameterValue'];
    //1小時內累積雨量
    $oneHour = $location[$i]['weatherElement'][0]['elementValue'];
    //24小時內累積雨量
    $oneDay = $location[$i]['weatherElement'][1]['elementValue'];

                //將儲存資料加入至資料庫
        
                DB::table('rain')->insert([
                    'city'=>$city,
                    'town'=>$town,
                    'townName'=>$townName,
                    'attribute'=>$attribute,
                    'oneHour'=>$oneHour,
                    'oneDay'=>$oneDay,

                ]);
    $i++;
}
}
}