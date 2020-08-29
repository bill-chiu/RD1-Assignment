<?php


$Authorization = 'CWB-1B75C5B5-3E1B-4775-96B4-7FA1A26DF256';


if (isset($_POST["btnOK"])) {

    $locationName = $_POST["locationName"];

    // $locationName = "宜蘭縣";

    $urllocationName =  urlencode($locationName);
    $url = ("https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=" . $Authorization . "&locationName=" . $urllocationName);
    // $url = ("https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=".$Authorization."&limit=1&locationName=".$locationName);

    $json = file_get_contents($url);
    $data = json_decode($json, true);
    // echo $json;
    // var_dump($json);
    // $data2 = $data['records']['locations'][0]['location'][0]['weatherElement'][0];

    // var_dump($data);
    // unset($json,$data2);

    // $startTime=$data2['startTime'];['parameterName']
    $PoP12h = $data['records']['locations'][0]['location'][0]['weatherElement'][0]['time'][0]['elementValue'][0]["value"];
    $startTime = $data['records']['locations'][0]['location'][0]['weatherElement'][0]['time'][0]['startTime'];
    $endTime = $data['records']['locations'][0]['location'][0]['weatherElement'][0]['time'][0]['endTime'];
    $AT = $data['records']['locations'][0]['location'][0]['weatherElement'][1]['time'][0]['elementValue'][0]["value"];
    $Wx = $data['records']['locations'][0]['location'][0]['weatherElement'][2]['time'][0]['elementValue'][0]["value"];
    $T = $data['records']['locations'][0]['location'][0]['weatherElement'][3]['time'][0]['elementValue'][0]["value"];
    $RH = $data['records']['locations'][0]['location'][0]['weatherElement'][4]['time'][0]['elementValue'][0]["value"];
    $CI=$data['records']['locations'][0]['location'][0]['weatherElement'][5]['time'][0]['elementValue'][1]["value"];
    $WeatherDescription=$data['records']['locations'][0]['location'][0]['weatherElement'][6]['time'][0]['elementValue'][0]["value"];

    // echo $locationName."天氣概況"."<br>";
    echo "開始時間:" . $startTime . "%" . "<br>";
    echo "結束時間:" . $endTime . "<br>";
    echo "12小時降雨機率:" . $PoP12h . "%<br>";
    echo "天氣現象:" . $AT . "<br>";
    echo "體感溫度:攝氏" . $Wx . "度<br>";
    echo "溫度:攝氏" . $T . "度<br>";
    echo "溫度:相對濕度" . $RH . "<br>";
    echo "舒適度:" . $CI . "<br>";
    echo "天氣預報綜合描述:" . $WeatherDescription . "<br>";
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