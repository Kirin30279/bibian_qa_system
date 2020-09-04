<?PHP
function loginCheck($data){
    $data = json_decode(base64_decode($data),true);
    $result = false;
    
    if (empty($data)){
        return false;
    } 
    $inTime = $data["expiretime"]-time();
    //登入過期
    if($inTime<=0){
       return false;
    }
   
    return true;
}
?>

