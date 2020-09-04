<?PHP
function doLogin($account,$password,$SQL_connect){
    //account跟password已經跳脫SQL特殊字元
    
    $responseLogin = array(
        'status' => false,
        'message' =>'',
        'data' =>'');//API回傳array初始化
    $logininfo = array();//logininfo初始化

    if ($SQL_connect->connect_error) {
        $responseLogin["message"] = '資料庫連線失敗。';
        return $responseLogin;
      }
    if(empty(trim($account))){
        $responseLogin["message"] = '請輸入帳號。';
        return $responseLogin;
    } 
    if(empty(trim($password))){
        $responseLogin["message"] = '請輸入密碼。';
        return $responseLogin;
    } 

    $login_sql = "SELECT * FROM users WHERE account = '$account'";
    $result = $SQL_connect->query($login_sql);
    if (!$result) {
        $responseLogin["message"] = '資料庫查詢失敗。';
        return $responseLogin;
    }
    
    if (!$resultArray = $result->fetch_array(MYSQLI_ASSOC)){
        $responseLogin["message"] = '帳號不存在。';
        return $responseLogin;
    }
    
    if ($password==$resultArray['passwd']){
        $logininfo=base64_encode(json_encode(array(
            "id" => $resultArray["account"],
            "name" => $resultArray["id"],
            "logintime" => time(),
            "expiretime" => time()+3600)));//3600秒
        $responseLogin = array(
            "status" => true,
            "message" => '',
            'data' =>$logininfo);
    } else{
        $responseLogin['status']= false;
        $responseLogin['message']= '密碼錯誤，請重新輸入。'; 
    }
    //回傳陣列，內含登入狀態、登入者ID、錯誤訊息
    // $retrunArray=array(
    //     'responseLogin'=> $responseLogin,
    //     'logininfo' =>$logininfo);
    return $responseLogin;
}

?>
