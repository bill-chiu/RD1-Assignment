<?php


$Authorization = 'CWB-1B75C5B5-3E1B-4775-96B4-7FA1A26DF256';


// if (isset($_POST["btnOK"])) {
$locationName = "宜蘭縣";

$urllocationName =  urlencode($locationName);
$url = ("https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=".$Authorization."&locationName=".$urllocationName);
// $url = ("https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=".$Authorization."&limit=1&locationName=".$locationName);

$json = file_get_contents($url);
$data = json_decode($json, true);
echo $json;
// var_dump($json);
// $data2 = $data['records']['locations'][0]['location'][0]['weatherElement'][0];

// var_dump($data);
// unset($json,$data2);

// $startTime=$data2['startTime'];['parameterName']
