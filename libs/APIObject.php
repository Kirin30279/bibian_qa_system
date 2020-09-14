<?php
class QASystem
{
    private $mysql_address = "";
    private $mysql_username = "";
    private $mysql_password = "";
    private $mysql_database = "";
    private $connect;
    private $error_message = "";
    private $login_token = "";
    private $user_name = ""; 

    public function __construct($mysql_address, $mysql_username, $mysql_password, $mysql_database) {
        $this->mysql_address  = $mysql_address;
        $this->mysql_username = $mysql_username;
        $this->mysql_password = $mysql_password;
        $this->mysql_database = $mysql_database;

        $this->connect = ($GLOBALS["___mysqli_ston"] = mysqli_connect($this->mysql_address, $this->mysql_username, $this->mysql_password));

        if (mysqli_connect_errno())
        {
            $this->error_message = "Failed to connect to MySQL: " . mysqli_connect_error();
            echo $this->error_message;
            return false;
        }
        mysqli_query($GLOBALS["___mysqli_ston"], "SET NAMES utf8");
        mysqli_query($this->connect, "SET NAMES utf8");
        mysqli_query($this->connect, "SET CHARACTER_SET_database= utf8");
        mysqli_query($this->connect, "SET CHARACTER_SET_CLIENT= utf8");
        mysqli_query($this->connect, "SET CHARACTER_SET_RESULTS= utf8");

        if(!(bool)mysqli_query($this->connect, "USE ".$this->mysql_database))$this->error_message = 'Database '.$this->mysql_database.' does not exist!';
    }
    
    public function __destruct() {
        mysqli_close($this->connect);
    }
    

    private function _getNameFromToken()
    {
        $this->user_name = json_decode(base64_decode($this->login_token),true)["name"];
    }


    //以下是public共用方法，目前只有login_token提取
    public function getLoginToken($token)
    {
        $this->login_token = $token;
    }



    // 以下是public方法forAPI，最後再寫
    public function doLogin($account,$password)
    {
        $result = array('status' => false, 'message' =>'', 'data' =>'');
        $account = mysqli_real_escape_string($this->connect,$account);
        $password = mysqli_real_escape_string($this->connect,$password);
        if(empty(trim($account))){
            $result["message"] = '請輸入帳號。';
            return $result;
        } 
        if(empty(trim($password))){
            $result["message"] = '請輸入密碼。';
            return $result;
        } 

         $login_sql = "SELECT * FROM users WHERE account = '$account'";
         $SQL_result = $this->connect->query($login_sql);
        if (!$SQL_result) {
            $result["message"] = '資料庫查詢失敗。';
            return $result;
        }
        
        if (!$resultArray = $SQL_result->fetch_array(MYSQLI_ASSOC)){
            $result["message"] = '帳號不存在。';
            return $result;
        }
        
        if ($password==$resultArray['passwd']){
            $logininfo=base64_encode(json_encode(array(
                "id" => $resultArray["account"],
                "name" => $resultArray["id"],
                "logintime" => time(),
                "expiretime" => time()+3600)));//3600秒
            $result = array(
                "status" => true,
                "message" => '',
                'data' =>$logininfo);
        } else{
            $result['status']= false;
            $result['message']= '密碼錯誤，請重新輸入。'; 
        }
        return $result;
    }


    public function getQADetailByoid($oid)
    {
        $result = array('status' => false,'message'=> '','data' => '');//result初始化

        if($oid->illegal){
            $result['message'] = "訂單編號：$oid->error_message";
            return $result;
        };
    
        $query = "SELECT list.isSend, list.status,
        qa.user_id, qa.time, qa.oid_Question, qa.PicFile
        FROM qa_list as list, customer_qa as qa
        WHERE list.oid=$oid->content AND qa.oid=$oid->content ";

        $SQL_query = $this->connect->query($query);
        $rows = $SQL_query->num_rows;
        if ($rows==0){
            $result['message'] = "訂單編號不存在，請重新輸入。";
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
    

    public function getQAListDataByPage($page)
    {
        $result = array('status' => false,'message'=> '','data' => '');//result初始化
        
        if($page->illegal){
            $result['message'] = "頁數：$page->error_message";
            return $result;
        };
    
        $showNum = (($page->content)-1)*50;
        
        $QA_list_SQL = 
        "SELECT * FROM `qa_list`  
        ORDER BY `status`ASC,`renew_time` DESC 
        LIMIT $showNum,50";     
    
        $SQL_result = $this->connect->query($QA_list_SQL);
    
        $rows = $SQL_result->num_rows;
        if ($rows==0) {
            $result['message'] = "查無資料，指定頁數過高。";
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

    public function writeQACustomerContent($oid, $qa_content, $qa_files)
    { 
        $result = array('status' => false,'message'=> '');//result初始化
        if($oid->illegal){
            $result['message'] = "訂單編號：".$oid->error_message;
            return $result;
        };
    
        $uploadtime = time();
        $date = date('Y-m-d H:i:s',$uploadtime);
        $this->_getNameFromToken();
        $user_name = $this->user_name;
        $filepath = '';
        if (!empty($qa_files)){
            $newFileName = $uploadtime.'_'.$qa_files['name'];
            $filepath = 'upload_test/' .  $newFileName;
            move_uploaded_file($qa_files['tmp_name'], $filepath); 
        }
    
        $insertSQL_Customer_qa = 
        "INSERT INTO customer_qa(oid,oid_Question,PicFile,user_id,time,IsCustomer)
            VALUES ($oid->content,'$qa_content','$filepath','$user_name','$date',1);
         INSERT INTO qa_list(oid,user_id,create_time,renew_time,status,type)
            VALUES ($oid->content,'$user_name','$date','$date',0,1)
            ON DUPLICATE KEY UPDATE 
            renew_time='$date', status = 0,type = 1;";
        $SQL_query = $this->connect->multi_query($insertSQL_Customer_qa);
     
        $result['status'] = true;
        return $result;   
        
    }

    public function writeQAFiles($upload)
    { 
        $result = array('status' => false,'message'=> '','data'=>'');//result初始化
        if (($upload['size']/1024/1024)>4){
            $result['message'] = "檔案大小大於4MB，請壓縮檔案再上傳。";
            return $result;
        }
    
        $newFileName = time().'_'.$upload['name'];
        $filepath = 'upload_test/' .  $newFileName;
        move_uploaded_file($upload['tmp_name'], $filepath);  
       
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

    public function writeQAServiceContent($oid, $qa_content, $is_send, $qa_status)
    {
        $result = array('status' => false,'message'=> '');//result初始化
        if($oid->illegal){
            $result['message'] = "訂單編號：".$oid->error_message;
            return $result;
        };
    
        if($is_send->illegal){
            $result['message'] = "送信確認：".$is_send->error_message;
            return $result;
        };
        
        if($qa_status->illegal){
            $result['message'] = "問答狀態：".$qa_status->error_message;
            return $result;
        };  
        
        $date = date('Y-m-d H:i:s',time());
        $this->_getNameFromToken();
        $user_name =  $this->user_name;

        $insertSql = 
        "INSERT INTO customer_qa(oid,oid_Question,PicFile,user_id,time,IsCustomer)
            VALUES ($oid->content,'$qa_content','','$user_name','$date',0);
        UPDATE qa_list 
            SET `renew_time`='$date',`isSend`=$is_send->content,`status`=$qa_status->content 
            WHERE oid = $oid->content;"; 
    
        $SQL_query = $this->connect->multi_query($insertSql);
        $result['status'] = true;
        return $result;
    }

} 












?>