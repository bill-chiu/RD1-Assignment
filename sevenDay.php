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
    <link rel="stylesheet" href="grid.css">
</head>

<!-- <style>
    #box {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        grid-gap: 20px;
        width: 1200px;
        height: 300px;
    }
</style> -->


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
        <h1> <?php
                $sql = <<<multi
        select * from sevenDay 
    multi;
                echo $locationName . "<br>";
                $result = mysqli_query($link, $sql);

                ?> <div><a><img src="image/country/<?= $locationName ?>.jpg" width="480" height="270"></a></div> </h1>
        <h1>一週天氣預報</h1>

        <div id="box" align="center">

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>



                <div>
                    <div style="background-color:#003D79 ">
                        <font color="white"><?= substr($row["startTime"], 5, 5) . "<br>" ?> </font>
                    </div>
                    <div style="background-color:#D2E9FF; "> <?= $row["Wx"] . "<br>" ?>

                        <a><img src="image/weather/<?= $row["Wx"] ?>.svg" width="100" height="100"></a>
                        <?= "<br>" . "溫度" . $row["MinT"] . "~" . $row["MaxT"] . "°C<br>" ?></div>



                    <div style="background-color:#ACD6FF; ">
                        <?php $row = mysqli_fetch_assoc($result) ?>
                        <!-- <?= substr($row["startTime"], 5, 5) . "<br>" ?> -->
                        <!-- <?= $row["startTime"] . "<br>" ?> -->
                        <?= $row["Wx"] . "<br>" ?>
                        <a><img src="image/weather/<?= $row["Wx"] ?>.svg" width="100" height="100"></a>
                        <?= "<br>" . "溫度" . $row["MinT"] . "~" . $row["MaxT"] . "°C<br>" ?>
                        <div style="background-color:#46A3FF; "> <font color="white">
                        <td><?= $row["WD"] . "<br>" ?></td>
                        <td><?= $row["WS"] . "公尺/秒<br>" ?></td> </font> </div>
                    </div>
                </div>

                <!-- <td><?= "最高體感溫度 攝氏" . $row["MaxAT"] . "<br>" ?></td>
                    <td><?= "最低體感溫度 攝氏" . $row["MinAT"] . "<br>" ?></td>
                    <td><?= "平均溫度 攝氏" . $row["T"] . "<br>" ?></td>
               
                    <td><?= "平均相對濕度 " . "<br>" ?></td> -->


            <?php } ?>
        </div>
    </form>
</body>

</html>