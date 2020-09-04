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

    $rows = $SQL_result->num_rows;
    if ($rows==0) {
        $message = "查無資料，指定頁數過高。";
        $result['message'] = $message;
        return $result; 
    }
    
    $QAListData  = $SQL_result->fetch_all(MYSQLI_ASSOC); 

    $QAListData = array_map(function($QAListData) {
        return array(
            'orderID'     => $QAListData['oid'],
            'otderType'   => $QAListData['type'],
            'nation'      => $QAListData['Nation'],
            'memberName'  => $QAListData['user_id'],
            'createdTime' => $QAListData['create_time'],
            'qaStatus'    => $QAListData['status']
        );
    }, $QAListData);

    $result = array(
        'status' => true,
        'message'=> '',
        'data' => $QAListData
    );
    return $result;
}
?>