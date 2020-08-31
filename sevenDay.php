<?php

$Authorization = 'CWB-1B75C5B5-3E1B-4775-96B4-7FA1A26DF256';
require("connDB.php");
if (isset($_POST["btnOK"])) {

    $sql = "DELETE FROM `sevenDay`";
    mysqli_query($link, $sql);

    $locationName = $_POST["locationName"];

    $urllocationName =  urlencode($locationName);
    $url = ("https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=" . $Authorization . "&locationName=" . $urllocationName);

    $json = file_get_contents($url);
    $data = json_decode($json, true);

    $i = 0;
    //取得天氣因子
    $weatherElement = $data['records']['locations'][0]['location'][0]['weatherElement'];

    while ($i < count($weatherElement[3]['time'])) {
        $startTime = $weatherElement[2]['time'][$i]['startTime'];
        $endTime = $weatherElement[2]['time'][$i]['endTime'];
        for ($j = 0; $j < count($weatherElement); $j++) {
            switch ($weatherElement[$j]['elementName']) {
                case "Wx":
                    $Wx = $weatherElement[$j]['time'][$i]['elementValue'][0]["value"];
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
        $WeatherDescription = explode("。", $weatherElement[10]['time'][$i]['elementValue'][0]["value"]);

        if (count($WeatherDescription) >= 7) {
            $PoP = $WeatherDescription[1];
            $Description = $WeatherDescription[3];
        } else
            $PoP = '';
        $Description = $WeatherDescription[2];

        $sql = <<<multi
    INSERT INTO sevenDay (startTime,endTime,Wx,MaxAT,MinAT,T,MaxT,MinT,RH,PoP,Description,WS,WD) VALUES
    ('$startTime', '$endTime','$Wx', '$MaxAT', '$MinAT','$T','$MaxT','$MinT','$RH','$PoP','$Description','$WS','$WD')
    multi;

        mysqli_query($link, $sql);
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

<style>

#seven{
    grid-template: 7,1fr;

}



</style>


<body>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <form id="form1" name="form1" method="post">
        <div class="form-group row">

            <div class="col-8">
                <select id="locationName" name="locationName" class="custom-select col-4 " required="required">
                    <option value="基隆市">基隆市</option>
                    <option value="臺北市">臺北市</option>
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
                <button name="btnOK" type="btnOK" class="btn btn-primary">Submit</button>
            </div>
        </div>
        <?php
        $sql = <<<multi
        select * from sevenDay 
    multi;
        echo $locationName . "天氣概況" . "<br>";
        $result = mysqli_query($link, $sql);

        ?>
             <table>一週天氣預報</table>
        <table>


        
            
        <tbody>
        <tr class="day">
          <th id="C10017" headers="County" rowspan="2">
            <a href="/V8/C/W/County/County.html?CID=10017" title="顯示基隆市預報頁面"><span class="heading_3">基隆市<i class="fa fa-plus-square" aria-hidden="true"></i></span></a>
          </th>
          <td headers="C10017 day1">
            <span class="signal">
              <img src="/V8/assets/img/weather_icons/weathers/svg_icon/day/10.svg" alt="陰時多雲短暫陣雨" title="陰時多雲短暫陣雨">
            </span>
            <p>
              <span class="tem-C is-active">27 - 34</span>
              <span class="tem-F is-hidden">81 - 93</span>
            </p>
          </td>         
        </tr>
        <tr class="night">
          <td headers="C10017 day1">
            <span class="signal">
              <img src="/V8/assets/img/weather_icons/weathers/svg_icon/night/03.svg" alt="多雲時晴" title="多雲時晴">
            </span>
            <p>
              <span class="tem-C is-active">28 - 31</span>
              <span class="tem-F is-hidden">82 - 88</span>
            </p>
          </td>
         
        </tr>
      </tbody>
</table>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>


       
            <table class="seven">

            

            <tr ><?= substr($row["startTime"], 5, 5) . "<br>" ?></tr>
                    <tr>    <?= "天氣現象:" . $row["Wx"] . "<br>" ?></tr>
                    <tr><?= "最高溫度" . $row["MaxT"] . "<br>" ?></tr>
                    <tr><?= "最低溫度" . $row["MinT"] . "<br>" ?></tr>

                    <!-- <td><?= "最高體感溫度 攝氏" . $row["MaxAT"] . "<br>" ?></td>
                    <td><?= "最低體感溫度 攝氏" . $row["MinAT"] . "<br>" ?></td>
                    <td><?= "平均溫度 攝氏" . $row["T"] . "<br>" ?></td>
               
                    <td><?= "平均相對濕度 " . "<br>" ?></td>
                    <td><?= "最大風速 " . $row["WS"] . "<br>" ?></td>
                    <td><?= "風向 " . $row["WD"] . "<br>" ?></td> -->
              





            </table>
            <table></table>








        <?php } ?>

    </form>
</body>

</html>