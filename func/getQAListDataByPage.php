<?PHP
function getQAListDataByPage($page,$connect){
    $result = array('status' => false,'message'=> '','data' => '');//result初始化
    if(!is_numeric($page)){
        $message = "輸入頁數不為數字。";
        $result['message'] = $message;
        return $result;
    }
    $showNum = ($page-1)*50;
    if ($connect->connect_error) {
        $message = "資料庫連線失敗:  $connect->connect_error";
        $result['message'] = $message;
        return $result;    
    }
    
    $QA_list_SQL = 
    "SELECT * FROM `qa_list`  
    ORDER BY `status`ASC,`renew_time` DESC 
    LIMIT $showNum,50";     

    $SQL_result = $connect->query($QA_list_SQL);
    if (!$SQL_result) {
        $message = "資料庫指令出錯。";
        $result['message'] = $message;
        return $result; 
    }

    $rows = $SQL_result->num_rows;
    if ($rows==0) {
        $message = "查無資料，指定頁數過高。";
        $result['message'] = $message;
        return $result; 
    }

    for ($j = 0 ; $j < $rows ; ++$j){
        $data_tmp = $SQL_result->fetch_array(MYSQLI_ASSOC);
        $data[$j]['orderID']     = $data_tmp['oid'];
        $data[$j]['otderType']   = $data_tmp['type'];
        $data[$j]['nation']      = $data_tmp['Nation'];
        $data[$j]['memberName']  = $data_tmp['user_id'];
        $data[$j]['createdTime'] = $data_tmp['create_time'];
        $data[$j]['qaStatus']    = $data_tmp['status'];
    }
    $result = array(
        'status' => true,
        'message'=> '',
        'data' => $data
    );
    return $result;
}
?>