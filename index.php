<html>
<title>抓天氣</title>
<style type="text/css">
<!--
body {
color:#3233EF;
margin: 0px;
}
-->
</style>
<html>
<body width="717" height="186"><font size="4">
<?php
function getTextBetweenTags( $string, $tagname ) {
    preg_match( "/\<{$tagname}\>(.*)\<\/{$tagname}\>/", $string, $matches );
    return $matches[1];
}

$contents = file_get_contents("http://realtek.accu-weather.com/widget/realtek/weather-data.asp?location=cityId:315040");
$pic = getTextBetweenTags( $contents, 'weathericon' ) ;
$out_pic = "https://developer.accuweather.com/sites/default/files/".$pic."-s.png";
?>
<img src="<?php echo $out_pic ?>">

</font>
</body>
</html>