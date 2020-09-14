<?php
include './libs/OrderID.php';//各種數字判斷式的class(之後要包在autoload裡面)
include './libs/LoginCheckFunction.php';//各api所呼叫的函數
include './libs/APIObject.php';//API用的class
date_default_timezone_set("Asia/Taipei");

$servername='localhost';//主機名稱
$username='root';//使用者名稱
$password='';//使用者PW
$dbname = "day5_qa";//DB名稱