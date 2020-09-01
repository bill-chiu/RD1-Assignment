<?php


$Authorization = 'CWB-1B75C5B5-3E1B-4775-96B4-7FA1A26DF256';
require("connDB.php");

$sql = "DELETE FROM `twoDay`";
mysqli_query($link, $sql);

    $locationName = $_POST["locationName"];

    $urllocationName =  urlencode($locationName);
    $url = ("https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=" . $Authorization . "&locationName=" . $urllocationName);

    $json = file_get_contents($url);
    $data = json_decode($json, true);
    $i = 0;
    $weatherElement = $data['records']['locations'][0]['location'][0]['weatherElement'];
    while ($i < count($weatherElement[3]['time'])) {

        // echo $i . "<br>";
        $startTime = $weatherElement[1]['time'][$i]['startTime'];
        $endTime = $weatherElement[1]['time'][$i]['endTime'];
        // echo ($startTime) . "<br>";
        // echo $endTime . "<br>";
        for ($j = 0; $j < count($weatherElement); $j++) {
            switch ($weatherElement[$j]['elementName']) {

                case "Wx":
                    $Wx = $weatherElement[$j]['time'][$i]['elementValue'][0]["value"];
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
        $WeatherDescription = explode("。", $weatherElement[6]['time'][$i]['elementValue'][0]["value"]);
        if (count($WeatherDescription) >= 5) {
            $PoP=$WeatherDescription[1];
            $Description=$WeatherDescription[3];
        }

        $sql = <<<multi
        INSERT INTO twoDay (startTime,endTime,Wx,T,RH,PoP,Description,WS,WD) VALUES
        ('$startTime', '$endTime','$Wx','$T','$RH','$PoP','$Description','$WS','$WD')
        multi;
        mysqli_query($link, $sql);
        $i++;

    }
