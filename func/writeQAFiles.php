<?PHP
function writeQAFiles($login_token,$upload,$connect){
    $result = array('status' => false,'message'=> '','data'=>'');//result初始化
    if (($upload['size']/1024/1024)>4){
        $message = "檔案大小大於4MB，請壓縮檔案再上傳。";
        $result['message'] = $message;
        return $result;
    }
    
    
    $uploadtime = time();
    $file = $upload['tmp_name'];
    $newFileName = $uploadtime.'_'.$upload['name'];
    $filepath = 'upload_test/' .  $newFileName;
    move_uploaded_file($file, $filepath);  
   
    $data = array(
        'data'  => $filepath, // 檔案路徑
        'name'  => $upload['name'], // 檔案名稱,
        'type'  => $upload['type'], // 檔案類型
        'error' => $upload['error'] // 錯誤訊息  
    );
    $result['status'] = true;
    $result['data'] = $data;
    return $result;
}




?>