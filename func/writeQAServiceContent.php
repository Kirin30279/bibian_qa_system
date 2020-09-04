<?php
function writeQAServiceContent($login_token,$oid,$qa_content,$is_send,$qa_status,$connect){
    $result = array('status' => false,'message'=> '');//result初始化
    $isCorrectFormat_oid = preg_match("/^[0-9]{10}$/",$oid);
    if(!$isCorrectFormat_oid){
        $message = "訂單編號不符格式。";
        $result['message'] = $message;
        return $result;
    }
    $date = date('Y-m-d H:i:s',time());
    $login_info = json_decode(base64_decode($login_token),true);
    $user_id = $login_info["name"];
   
    $isCorrectFormat_is_send = preg_match("/^[0-1]$/",$is_send);
    if(!$isCorrectFormat_is_send){
        $message = "送信與否不符格式。";
        $result['message'] = $message;
        return $result;
    }
    
    $isCorrectFormat_qa_status = preg_match("/^[0-1]$/",$qa_status);
    if(!$isCorrectFormat_qa_status){
        $message = "問答狀態不符格式。";
        $result['message'] = $message;
        return $result;
    }
    
    $insertSql = 
     "INSERT INTO customer_qa(oid,oid_Question,PicFile,user_id,time,IsCustomer)
        VALUES ($oid,'$qa_content','','$user_id','$date',0);
    UPDATE qa_list 
        SET `renew_time`='$date',`isSend`=$is_send,`status`=$qa_status 
        WHERE oid = $oid;"; 
   
    $SQL_query = $connect->multi_query($insertSql);
    $result['status'] = true;
    return $result;
}
?>