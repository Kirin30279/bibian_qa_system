<?php

// include './libs/DatabaseAccessObject.php';
// $DB = new DatabaseAccessObject('localhost', 'root', '', 'day5_qa');
// //var_dump($DB);

// $ans = $DB->query('users', '1=1', $order_by = "1", $fields = "*", $limit = "");
// print_r($ans);
// $ans2 = $DB->query('customer_qa', 'oid=6655442233', $order_by = "1", $fields = "*", $limit = "");
// print_r($ans2);

include './libs/OrderID.php';
$oid         = new OrderId($_POST['oid']);
//var_dump($oid->isillegal());
if($oid->isillegal()){
    echo"訂單編號不合格式";
} else{
    echo"訂單編號OK";
}
var_dump($oid);


$issend      = new IsSend($_POST['isSend']);

if($issend->isIllegal()){
    echo"送信不合格式";
} else{
    echo"送信OK";
}

$qa_status   = new QAStatus($_POST['qaStatus']);

if($qa_status->isIllegal()){
    echo"狀態不合格式";
} else{
    echo"狀態OK";
}


//var_dump($oid->isIllegal);
// if($oid->oid==""){
//     echo "false";
// }
// echo $oid->oid;
// echo $oid->displayoid();


