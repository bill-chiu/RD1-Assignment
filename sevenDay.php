<?php

$sql = "DELETE FROM `sevenDay`";
mysqli_query($link, $sql);


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
    $sql = <<<multi
INSERT INTO sevenDay (startTime,Wx,WxV,MaxAT,MinAT,MaxT,MinT,PoP,Description,WS,WD) VALUES
('$startTime', '$Wx',$WxV, '$MaxAT', '$MinAT','$MaxT','$MinT','$PoP','$Description','$WS','$WD')
multi;

    mysqli_query($link, $sql);
    $i++;
}
