<?php

$Authorization = 'CWB-1B75C5B5-3E1B-4775-96B4-7FA1A26DF256';
require("connDB.php");

$sql = "DELETE FROM `today`";
mysqli_query($link, $sql);

$locationName = $_POST["locationName"];

$urllocationName =  urlencode($locationName);
$url = ("https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=".$Authorization."&locationName=".$urllocationName);

$json = file_get_contents($url);
$data = json_decode($json, true);

//取得天氣因子
$weatherElement = $data['records']['location'][0]['weatherElement'];
$Wx=$weatherElement[0]['time'][0]['parameter']["parameterName"];
$PoP=$weatherElement[1]['time'][0]['parameter']["parameterName"];
$MinT=$weatherElement[2]['time'][0]['parameter']["parameterName"];
$MaxT=$weatherElement[4]['time'][0]['parameter']["parameterName"];
$CI=$weatherElement[3]['time'][0]['parameter']["parameterName"];

$sql = <<<multi
INSERT INTO today (Wx,MaxT,MinT,PoP) VALUES
('$Wx','$MaxT','$MinT','$PoP')
multi;
mysqli_query($link, $sql);
?>

