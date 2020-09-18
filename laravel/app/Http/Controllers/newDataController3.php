<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use DB;
// class newDataController3 extends Controller
// {
//     public function newdata()
//     {

        $Authorization = 'CWB-1B75C5B5-3E1B-4775-96B4-7FA1A26DF256';
        $locationName = "新竹縣";
        $urllocationName =  urlencode($locationName);
        DB::table('sevenDay')->delete();

        $url = ("https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=" . $Authorization . "&locationName=" . $urllocationName);

        $json = file_get_contents($url);
        $data = json_decode($json, true);
        
        $i = 0;
        //取得天氣因子
        $weatherElement = $data['records']['locations'][0]['location'][0]['weatherElement'];
        
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

     
    // }
// }

?>