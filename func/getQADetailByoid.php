<?PHP
function getQADetailByoid($oid,$connect){
    $result = array('status' => false,'message'=> '','data' => '');//result初始化
    $isCorrectFormat = preg_match("/^[0-9]{10}$/",$oid);
    
    if(!$isCorrectFormat){
        $message = "訂單編號不符格式。";
        $result['message'] = $message;
        return $result;
    }

    $QA_list_SQL =
    "SELECT * FROM `qa_list` WHERE `oid`=$oid";//讀取回答狀態、送信狀態
    $resultQA_list = $connect->query($QA_list_SQL);
    $QA_SQL = 
    "SELECT * FROM `customer_qa` WHERE `oid`=$oid 
    ORDER BY `time` ASC";//讀取問答內容
    $resultQA = $connect->query($QA_SQL);
    if (!$resultQA||!$resultQA_list) {
        $message = "資料庫讀不到資料。";
        $result['message'] = $message;
        return $result;
    }
    $rows = $resultQA->num_rows;
    if ($rows==0){
        $message = "訂單編號不存在，請重新輸入。";
        $result['message'] = $message;
        return $result;

    }
    $dataArray = array();

    $QAlistData = $resultQA_list->fetch_array(MYSQLI_ASSOC);//QAlist存回答狀態、寫信與否
    $dataArray['isSend'] = $QAlistData['isSend'];
    $dataArray['status'] = $QAlistData['status'];

    for ($j = 0 ; $j < $rows ; ++$j){
        $data_tmp  = $resultQA->fetch_array(MYSQLI_ASSOC);    
        $items[$j]['name'] = $data_tmp['user_id'];
        $items[$j]['createdTime'] = $data_tmp['time'];
        $items[$j]['contents'] = $data_tmp['oid_Question'];
        $items[$j]['files'] = $data_tmp['PicFile'];
    }
    
    $dataArray['items'] = $items;
    $result = array(
        'status' => true,
        'message'=> '',
        'data' => $dataArray
    );
    

    return $result;
}


?>