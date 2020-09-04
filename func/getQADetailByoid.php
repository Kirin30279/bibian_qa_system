<?PHP
function getQADetailByoid($oid,$connect){
    $result = array('status' => false,'message'=> '','data' => '');//result初始化
    $isCorrectFormat = preg_match("/^[0-9]{10}$/",$oid);
    
    if(!$isCorrectFormat){
        $message = "訂單編號不符格式。";
        $result['message'] = $message;
        return $result;
    }

    $query =   "SELECT list.isSend, list.status,
    qa.user_id, qa.time, qa.oid_Question, qa.PicFile
    FROM qa_list as list, customer_qa as qa
    WHERE list.oid=$oid AND qa.oid=$oid ";
    
    $SQL_query = $connect->query($query);
    $rows = $SQL_query->num_rows;
    if ($rows==0){
        $message = "訂單編號不存在，請重新輸入。";
        $result['message'] = $message;
        return $result;
    }

    $SQL_result = $SQL_query->fetch_all(MYSQLI_ASSOC); 
    $QAContentData = array_map(function($SQL_result) {
        return array(
            'name'        => $SQL_result['user_id'],
            'createdTime' => $SQL_result['time'],
            'contents'    => $SQL_result['oid_Question'],
            'files'       => $SQL_result['PicFile']
        );
    }, $SQL_result);
  
    $result = array(
        'status' => true,
        'message'=> '',
        'data'   => array(
            'isSend' => $SQL_result[0]['isSend'],
            'stasus' => $SQL_result[0]['status'],
            'items'  => $QAContentData
        )
    );
    return $result;

}


?>