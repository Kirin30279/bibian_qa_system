<?PHP
include './configs/API_Include.php';
$QASystem = new QASystem($servername, $username, $password, $dbname);

$act = $_POST['act'];// 需求辨識值
if ($act == "checkLogin"){
    $account = $_POST['account'];//免檢查，有跳脫
    $password = $_POST['passwd'];
    $result = $QASystem->doLogin($account,$password);
    echo json_encode($result);
    exit();
}

$login_token = $_POST['login_token'];
$islogin = loginStatusCheck($login_token);//若做登入以外的操作，則先讀是否登入
if (!$islogin){
    echo json_encode(array());
    exit();//沒登入or登入過期回傳空值並退出API
}
$QASystem->getLoginToken($login_token);//把login_token存起來

switch ($act) {
    case 'checkQAList':// index.php--應要分為客服查詢or客戶查詢，或者禁止客戶訪問  
            $page =new NumberPOST($_POST['page']);//顯示第n頁，等等會做計算，這裡不用跳脫
            $result = $QASystem->getQAListDataByPage($page);
            echo json_encode($result);     
        break;
        
    case 'checkQADetail':// detail.php
            $oid = new OrderID($_POST['oid']);//會用正則表達確認資料，不用跳脫
            $result = $QASystem->getQADetailByoid($oid);
            echo json_encode($result);
        break;
          
    case 'checkUpdateQASContent':// 寫入專員回覆
            $oid = new OrderID($_POST['oid']);//會用正則表達確認資料，不用跳脫
            $qa_content = htmlspecialchars($_POST['qaContent']);
            $is_send = new IsSend($_POST['isSend']);//有確認免跳脫
            $qa_status =new QAStatus($_POST['qaStatus']);//有確認免跳脫
            $result = $QASystem->writeQAServiceContent($oid,$qa_content,$is_send,$qa_status);
            echo json_encode($result);   
        break;
       
    case 'checkUpdateQAFiles':
            $upload = $_FILES['upload'];
            $result = $QASystem->writeQAFiles($upload);
            echo json_encode($result);   
        break;
    
    case 'checkUpdateQACContent':
            $oid = new OrderID($_POST['oid']);//會用正則表達確認資料，不用跳脫
            $qa_content = htmlspecialchars($_POST['qaContent']);
            $qa_files = '';
            if($_FILES){
                $qa_files = $_FILES['qaFiles'];
            }
            $result = $QASystem->writeQACustomerContent($oid,$qa_content,$qa_files);
            echo json_encode($result); 
        break;
        
    default:
        $result = array(
            'status' => false,
            'message' => "指定act錯誤。"
        ); 
        echo json_encode($result); 
        break;
}


?>