<?php
$sql = "DELETE FROM `today`";
mysqli_query($link, $sql);

$url = ("https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=".$Authorization."&locationName=".$urllocationName);

$json = file_get_contents($url);
$data = json_decode($json, true);

//取得天氣因子
$weatherElement = $data['records']['location'][0]['weatherElement'];
//天氣現象描述
$Wx=$weatherElement[0]['time'][0]['parameter']["parameterName"];
//天氣圖片vaiue
$WxV=$weatherElement[0]['time'][0]['parameter']["parameterValue"];
//降雨機率
$PoP=$weatherElement[1]['time'][0]['parameter']["parameterName"];
//最高跟最低溫
$MinT=$weatherElement[2]['time'][0]['parameter']["parameterName"];
$MaxT=$weatherElement[4]['time'][0]['parameter']["parameterName"];

//將儲存資料加入至資料庫
$sql = <<<multi
INSERT INTO today (Wx,WxV,MaxT,MinT,PoP) VALUES
('$Wx','$WxV','$MaxT','$MinT','$PoP')
multi;
mysqli_query($link, $sql);
?>

