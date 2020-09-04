<?PHP
function writeQACustomerContent($login_token,$oid,$qa_content,$qa_files,$connect){
    $result = array('status' => false,'message'=> '');//result初始化
    $isCorrectFormat_oid = preg_match("/^[0-9]{10}$/",$oid);
    if(!$isCorrectFormat_oid){
        $message = "訂單編號不符格式。";
        $result['message'] = $message;
        return $result;
    }
    $uploadtime = time();
    $date = date('Y-m-d H:i:s',$uploadtime);
    $login_info = json_decode(base64_decode($login_token),true);
    $user_name = $login_info["name"];
    $filepath = '';
    if (!empty($qa_files)){
        $file = $qa_files['tmp_name'];
        $newFileName = $uploadtime.'_'.$qa_files['name'];
        $filepath = 'upload_test/' .  $newFileName;
        move_uploaded_file($file, $filepath); 
    }
 


    $insertSQL_Customer_qa = 
    "INSERT INTO customer_qa(oid,oid_Question,PicFile,user_id,time,IsCustomer)
    VALUES ($oid,'$qa_content','$filepath','$user_name','$date',1)";
    mysqli_query($connect, $insertSQL_Customer_qa);

    //第二筆上傳，方便後台列表顯示
    $insertSQL_QA_list = 
    "INSERT INTO qa_list(oid,user_id,create_time,renew_time,status,type)
    VALUES ($oid,'$user_name','$date','$date',0,1)
    ON DUPLICATE KEY UPDATE 
    renew_time='$date', status = 0,type = 1";
    mysqli_query($connect, $insertSQL_QA_list);  


 
   
    $result['status'] = true;
    return $result;   
}













?>