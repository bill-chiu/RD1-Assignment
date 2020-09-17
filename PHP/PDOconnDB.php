<?php 

 //首先，先來定義資料庫相關存取資料

$db_host = "localhost";

$db_user = "root";

$db_pass = "";

$db_select = "myweather";

$db_port = 3306;

//使用PDO存取資料庫時，需要將資料庫依下列格式撰寫，讓程式讀取資料庫

$dbconnect ="mysql:host=$db_host;dbname=$db_select;port=$db_port;charset=utf8";

//建立使用PDO方式連線的物件，並放入指定的相關資料

$link = new PDO($dbconnect, $db_user, $db_pass);













?>