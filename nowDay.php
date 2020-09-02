<?php
session_start();
$sql = "DELETE FROM `today`";
mysqli_query($link, $sql);

$urllocationName =  urlencode($_SESSION['city']);

$url = ("https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=".$Authorization."&locationName=".$urllocationName);

$json = file_get_contents($url);
$data = json_decode($json, true);

//取得天氣因子
$weatherElement = $data['records']['location'][0]['weatherElement'];
$Wx=$weatherElement[0]['time'][0]['parameter']["parameterName"];
$WxV=$weatherElement[0]['time'][0]['parameter']["parameterValue"];
$PoP=$weatherElement[1]['time'][0]['parameter']["parameterName"];
$MinT=$weatherElement[2]['time'][0]['parameter']["parameterName"];
$MaxT=$weatherElement[4]['time'][0]['parameter']["parameterName"];
$CI=$weatherElement[3]['time'][0]['parameter']["parameterName"];

$sql = <<<multi
INSERT INTO today (Wx,WxV,MaxT,MinT,PoP) VALUES
('$Wx','$WxV','$MaxT','$MinT','$PoP')
multi;
mysqli_query($link, $sql);
?>

