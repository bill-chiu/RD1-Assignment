<?php
  // 建立MySQL的資料庫連接 
$link = mysqli_connect("localhost", "root", "root", "myweather",8889)  or die("無法開啟MySQL資料庫連接!<br/>");
  //送出UTF8編碼的MySQL指令
mysqli_query($link, "set names utf8");

?>