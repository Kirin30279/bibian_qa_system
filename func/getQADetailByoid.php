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
    "SELECT isSend,status FROM `qa_list` WHERE `oid`=$oid";//讀取回答狀態、送信狀態
    $resultQA_list = $connect->query($QA_list_SQL);

    $QA_SQL = 
    "SELECT user_id,time,oid_Question,PicFile FROM `customer_qa` WHERE `oid`=$oid 
    ORDER BY `time` ASC";//讀取問答內容
    $resultQA = $connect->query($QA_SQL);

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

    $QAContentData  = $resultQA->fetch_all(MYSQLI_ASSOC); 

    $QAContentData = array_map(function($QAContentData) {
        return array(
            'name'        => $QAContentData['user_id'],
            'createdTime' => $QAContentData['time'],
            'contents'    => $QAContentData['oid_Question'],
            'files'       => $QAContentData['PicFile']
        );
    }, $QAContentData);
        
    $dataArray['items'] = $QAContentData;
    $result = array(
        'status' => true,
        'message'=> '',
        'data'   => $dataArray
    );
    

    return $result;
}


?>