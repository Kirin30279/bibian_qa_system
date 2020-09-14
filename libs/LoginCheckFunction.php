<?php
function loginStatusCheck($data){
    $data = json_decode(base64_decode($data),true);
    $result = false;
    
    if (empty($data)){
        return false;
    } 
    $inTime = $data["expiretime"]-time();
   
    if($inTime<=0){//登入過期
       return false;
    }
   
    return true;
}
?>