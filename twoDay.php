<?php

$Authorization = 'CWB-1B75C5B5-3E1B-4775-96B4-7FA1A26DF256';
require("connDB.php");
if (isset($_POST["btnOK"])) {

    $locationName = $_POST["locationName"];

    echo $locationName . "天氣概況" . "<br>";
    $urllocationName =  urlencode($locationName);
    $url = ("https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=" . $Authorization . "&locationName=" . $urllocationName);

    $json = file_get_contents($url);
    $data = json_decode($json, true);
    $i = 0;
    $weatherElement = $data['records']['locations'][0]['location'][0]['weatherElement'];
    while ($i < count($weatherElement[3]['time'])) {

        echo $i . "<br>";
        $startTime = $weatherElement[1]['time'][$i]['startTime'];
        $endTime = $weatherElement[1]['time'][$i]['endTime'];
        echo ($startTime) . "<br>";
        echo $endTime . "<br>";
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
        echo "天氣現象:" . $Wx . "<br>";
        echo "體感溫度 攝氏" . $AT . "度<br>";
        echo "溫度 攝氏" . $T . "度<br>";
        echo "相對濕度 " . $RH . "%<br>";
        $WeatherDescription = explode("。", $weatherElement[6]['time'][$i]['elementValue'][0]["value"]);
        if (count($WeatherDescription) >= 7) {
            echo $WeatherDescription[1] . "<br>";
            echo "天氣描述 " . $WeatherDescription[3] . "<br>";
        }
        echo "風速 " . $WS . "公尺/秒<br>";
        echo "風向 " . $WD . "<br>";
        $i++;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <form id="form1" name="form1" method="post">
        <div class="form-group row">
            <label for="locationName" class="col-4 col-form-label">縣市</label>
            <div class="col-8">
                <select id="locationName" name="locationName" class="custom-select col-4 " required="required">
                    <option value="基隆市">基隆市</option>
                    <option value="台北市">台北市</option>
                    <option value="新北市">新北市</option>
                    <option value="宜蘭縣">宜蘭縣</option>
                    <option value="桃園市">桃園市</option>
                    <option value="新竹縣">新竹縣</option>
                    <option value="新竹市">新竹市</option>
                    <option value="苗栗縣">苗栗縣</option>
                    <option value="臺中市">臺中市</option>
                    <option value="彰化縣">彰化縣</option>
                    <option value="南投縣">南投縣</option>
                    <option value="雲林縣">雲林縣</option>
                    <option value="嘉義縣">嘉義縣</option>
                    <option value="嘉義市">嘉義市</option>
                    <option value="臺南市">臺南市</option>
                    <option value="高雄市">高雄市</option>
                    <option value="屏東縣">屏東縣</option>
                    <option value="臺東縣">臺東縣</option>
                    <option value="花蓮縣">花蓮縣</option>
                    <option value="澎湖縣">澎湖縣</option>
                    <option value="金門縣">金門縣</option>
                    <option value="連江縣">連江縣</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-4 col-8">
                <button name="btnOK" type="btnOK" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</body>

</html>