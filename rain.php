<?php
session_start();
require("PDOconnDB.php");
$link->exec("DELETE FROM `rain`");
$Authorization = 'CWB-1B75C5B5-3E1B-4775-96B4-7FA1A26DF256';

//如果按下查詢天氣
if (isset($_POST["btnOK"])) {
    //記錄輸入得城市
    $locationName = $_POST["locationName"];
    //將其暫存到SESSION
    $_SESSION['city'] = $locationName;
    //跳轉到天氣頁面
    header("Location: index.php");
}
//如果按下查詢雨量
if (isset($_POST["btnRain"])) {
    //記錄選擇的城市
    $locationName = $_POST["locationName"];
} else {
    //如果是從天氣頁面跳轉 則紀錄儲存的SESSION
    $locationName = $_SESSION['city'];
}
$urllocationName =  urlencode($locationName);

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

    $sql = <<<multi
    INSERT INTO rain (city,town,townName,attribute,oneHour,oneDay) VALUES
    ('$city','$town','$townName','$attribute','$oneHour','$oneDay')
    multi;
    // mysqli_query($link, $sql);
    $link->exec($sql);
    $i++;
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

<style>

</style>

<body style="background-color:#ECFFFF	; ">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



    <div style="background-color:#2894FF" align="center">
        <h1>
            <font color="#EEFFFF ">個人氣象站</font>
        </h1>
    </div>

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
                <button name="btnOK" type="btnOK" class="btn btn-primary">查詢天氣</button>
                <button name="btnRain" type="btnRain" class="btn btn-primary">查詢雨量</button>

            </div>
        </div>
    </form>
    <h2><?= $locationName . "雨量報告<br>"; ?></h2>
    <div id="boxa">


        <?php

        //查詢所選縣市觀測站 並按照鄉鎮排序
        $sql = "select * from rain WHERE city='$locationName' ORDER BY `rain`.`town` ASC";
        

 
    // $rainresult = mysqli_query($link, $sql);
        $rainresult =$link->query($sql);
        $i = 0;
        while ($row=$rainresult->fetch()) { ?>
            <div>
                <div style="background-color:#003D79 " align="center">
                    <font color="white">

                        <?php

                        $i++;
                        echo "觀測站: " . $row['townName'] . "<br>"; ?>

                    </font>
                </div>
                <div style="background-color:#D2E9FF; ">
                    <?php echo   "站址: " . $row['city'] . ' ' . $row['town'] . "<br>";

                    echo "隸屬: " . $row['attribute'] . "<br>";

                    if ($row['oneHour'] >= 0) {

                        echo '過去1小時累積雨量: ' . $row['oneHour']  . "<br>";
                    } else {
                        echo '過去1小時累積雨量: 無檢測紀錄' . "<br>";
                    }

                    if ($row['oneDay'] >= 0) {

                        echo '過去24小時累積雨量: ' . $row['oneDay'] . "<br>";
                    } else {
                        echo '過去24小時累積雨量: 無檢測紀錄' . "<br>";
                    }
                    ?>
                </div>
            </div>
        <?php } ?>
    </div>
</body>

</html>