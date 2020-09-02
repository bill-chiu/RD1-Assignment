<?php

$sql = "DELETE FROM `twoDay`";
mysqli_query($link, $sql);


$url = ("https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=" . $Authorization . "&locationName=" . $urllocationName);

$json = file_get_contents($url);
$data = json_decode($json, true);
$i = 0;
$weatherElement = $data['records']['locations'][0]['location'][0]['weatherElement'];
while ($i < count($weatherElement[3]['time'])) {


    $startTime = $weatherElement[1]['time'][$i]['startTime'];

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
            case "WD":
                $WD = $weatherElement[$j]['time'][$i]['elementValue'][0]["value"];
                break;
            default:
        }
    }
    //用句號切開秒數句並記錄需要的內容
    $WeatherDescription = explode("。", $weatherElement[6]['time'][$i]['elementValue'][0]["value"]);
    if (count($WeatherDescription) >= 5) {
        $PoP = $WeatherDescription[1];
        $Description = $WeatherDescription[3];
    }
    //將儲存資料加入至資料庫
    $sql = <<<multi
        INSERT INTO twoDay (startTime,Wx,WxV,T,RH,PoP,Description,WS,WD) VALUES
        ('$startTime','$Wx',$WxV,'$T','$RH','$PoP','$Description','$WS','$WD')
        multi;
    mysqli_query($link, $sql);
    $i++;
}
