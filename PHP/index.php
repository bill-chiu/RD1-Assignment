<?php
session_start();
$Authorization = 'CWB-1B75C5B5-3E1B-4775-96B4-7FA1A26DF256';
require("PDOconnDB.php");

$locationName = "基隆市";
$urllocationName =  urlencode($locationName);
//如果按下查詢天氣
if (isset($_POST["btnOK"])) {
    //記錄選擇的縣市
    $locationName = $_POST["locationName"];
    //解析成網址
    $urllocationName =  urlencode($locationName);
    //資料庫記錄即時/兩天/一週的資料
    require("today.php");
    require("twoDay.php");
    require("sevenDay.php");
} else {


    //如果是從雨量頁面跳轉 則紀錄儲存的SESSION
    if(isset($_SESSION['city'])){
    $locationName = $_SESSION['city'];
    }
    //解析成網址
    $urllocationName =  urlencode($locationName);
    //資料庫記錄即時/兩天/一週的資料
    require("today.php");
    require("twoDay.php");
    require("sevenDay.php");
}
//如果按下查詢雨量
if (isset($_POST["btnRain"])) {
    //記錄輸入得城市
    $locationName = $_POST["locationName"];
    //將其暫存到SESSION
    $_SESSION['city'] = $locationName;
    //跳轉到雨量頁面
    header("Location: rain.php");
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
        <div id="boxb">
            <h2>
                <?= $locationName . "天氣報告<br>"; ?>

                <a><img src="image/country/<?= $locationName ?>.jpg" width="480" height="270"></a>
            </h2>
            <?php
            //搜尋兩天的表並儲存最即時的當前溫度
            $sql = 'select * from twoDay';
            $tworesult =$link->query($sql);
            $row=$tworesult->fetch();  ?>
            <h1>
                <div> <?php $T = $row["T"];  ?></div>
            </h1>



            <?php
            //搜尋今天的表並顯示表的內容
            $sql =  'select * from toDay';

            $nowresult =$link->query($sql);
            ?>
            <div>

                <?php   $row=$nowresult->fetch();  ?>
                <div align="center">

                    <h3>
                        <div> <?= $row["Wx"] . "<br>" ?>

                            <a><img src="image/weather/<?= $row["WxV"] ?>.svg" width="200" height="200"></a>
                    </h3>
                    <h1><?= $T . "°C<br>" ?> </h1>

                    <h3> <?= $row["MinT"] . ' / ' . $row["MaxT"] . "°C<br>" ?>

                        <?= "降雨機率 " . $row["PoP"] . "％<br>" ?>
                    </h3>
                </div>
            </div>
        </div>
        </div>
        <h3>明後天天氣預報</h3>

        <?php

        //記錄明天後天的日期
        $date1 = date("Y-m-d", strtotime("1 day"));
        $date2 = date("Y-m-d", strtotime("2 day"));
        //篩選早晚6:00以及明後天的資料
        $sql = <<<multi
        select * from twoDay WHERE (`startTime` LIKE '%6:00%' OR `startTime` LIKE '%18:00%') and (`startTime` LIKE '$date1%' OR `startTime` LIKE '$date2%') 
    multi;

        $tworesult =$link->query($sql);
        ?>
        <div id="boxa" align="center">

            <?php  while ($row=$tworesult->fetch()) { ?>
                <div>
                    <div style="background-color:#003D79 ">

                        <?php
                        //建立一個陣列去轉換星期
                        $week = array("日", "一", "二", "三", "四", "五", "六");
                        //用空格分割startTime
                        list($date) = explode(" ", $row["startTime"]);
                        //用底線分割date
                        list($Y, $M, $D) = explode("-", $date);
                        ?>

                        <font color="white"><?= substr($row["startTime"], 5, 5) . "  星期" . $week[date("w", mktime(0, 0, 0, $M, $D, $Y))]; ?>
                        </font>
                    </div>

                    <div style="background-color:#D2E9FF; "> <?= $row["Wx"] . "<br>" ?>

                        <a><img src="image/weather/<?= $row["WxV"] ?>.svg" width="100" height="100"></a>
                        <?php echo "<br>" . "溫度" .  $row["T"] . "°C<br>"; ?>
                        <?= $row["PoP"] . "<br>" ?>
                    </div>

                    <div style="background-color:#ACD6FF; ">
                        <?php $row=$tworesult->fetch() ?>

                        <?= $row["Wx"] . "<br>" ?>
                        <a><img src="image/weather/<?= $row["WxV"] ?>.svg" width="100" height="100"></a>
                        <?= "<br>" . "溫度" . $row["T"] . "°C<br>" ?>
                        <?= $row["PoP"] . "<br>" ?>
                        <div style="background-color:#46A3FF; ">
                            <font color="white">
                                <td><?= $row["WD"] . "<br>" ?></td>
                                <td><?= $row["WS"] . "公尺/秒<br>" ?></td>
                            </font>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>
        <?php
        //記錄今天日期
        $date = date("Y-m-d");
        $sql = <<<multi
        select * from sevenDay WHERE `startTime` > '$date%' 
    multi;
       
        $sevenresult =$link->query($sql);

        ?>

        <h3>一週天氣預報</h3>
        <div id="box" align="center">

            <?php while ($row=$sevenresult->fetch())  { ?>

                <div>
                    <div style="background-color:#003D79 ">
                        <?php
                        //建立一個陣列去轉換星期
                        $week = array("日", "一", "二", "三", "四", "五", "六");
                        //用空格分割startTime
                        list($date) = explode(" ", $row["startTime"]);
                        //用底線分割date
                        list($Y, $M, $D) = explode("-", $date);
                        ?>
                        <font color="white"><?= substr($row["startTime"], 5, 5) . "  星期" . $week[date("w", mktime(0, 0, 0, $M, $D, $Y))]; ?>
                        </font>
                    </div>
                    <div style="background-color:#D2E9FF; "> <?= $row["Wx"] . "<br>" ?>

                        <a><img src="image/weather/<?= $row["WxV"] ?>.svg" width="60" height="60"></a>
                        <?php echo "<br>" . "溫度" . $row["MinT"] . "~" . $row["MaxT"] . "°C<br>";
                        $MinAT = $row["MinAT"];
                        $MaxAT = $row["MaxAT"];

                        ?></div>

                    <div style="background-color:#ACD6FF; ">
                        <?php $row=$sevenresult->fetch() ?>
                        <?= $row["Wx"] . "<br>" ?>
                        <a><img src="image/weather/<?= $row["WxV"] ?>.svg" width="60" height="60"></a>
                        <?= "<br>" . "溫度" . $row["MinT"] . "~" . $row["MaxT"] . "°C<br>" ?>
                        <div style="background-color:#D2E9FF; ">
                            <?= "體感溫度 " . $MinAT . "~" . $MaxAT . "°C" ?></div>
                        <div style="background-color:#46A3FF; ">
                            <font color="white">
                                <td><?= $row["WD"] . "<br>" ?></td>
                                <td><?= $row["WS"] . "公尺/秒<br>" ?></td>
                            </font>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>
    </form>
</body>

</html>