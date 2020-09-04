<?PHP
// "id": "testuser",
// "name": "測試登入",
// "logintime": 1599018342,
// "expiretime": 1599618342
include 'DB_config.php';
date_default_timezone_set("Asia/Taipei");
$act = $_POST['act'];// 需求辨識值
if ($act == "checkLogin"){
    $account = mysqli_real_escape_string($connect,$_POST['account']);
    $password = mysqli_real_escape_string($connect,$_POST['passwd']);
    include './func/doLogin.php';
    $result = doLogin($account,$password,$connect);

    echo json_encode($result);
    exit();
}

//若做登入以外的操作，則先讀是否登入
$login_token = $_POST['login_token'];
include './func/loginCheck.php';
$islogin = loginCheck($login_token);
if (!$islogin){
    echo json_encode(array());
    exit();//沒登入or登入過期回傳空值並退出API
}

switch ($act) {
    case 'checkQAList':// index.php--應要分為客服查詢or客戶查詢，或者禁止客戶訪問  
            $page = $_POST['page'];//顯示第n頁，等等會做計算，這裡不用跳脫
            include './func/getQAListDataByPage.php';
            $result = getQAListDataByPage($page,$connect);
            echo json_encode($result);     
        break;
        
    case 'checkQADetail':// detail.php
            $oid = $_POST['oid'];//會用正則表達確認資料，不用跳脫
            include './func/getQADetailByoid.php';
            $result = getQADetailByoid($oid,$connect);
            echo json_encode($result);
        break;
          
    case 'checkUpdateQASContent':// 寫入專員回覆
            $oid = $_POST['oid'];//會用正則表達確認資料，不用跳脫
            $qa_content = htmlspecialchars($_POST['qaContent']);
            $is_send = $_POST['isSend'];//有確認免跳脫
            $qa_status = $_POST['qaStatus'];//有確認免跳脫
            include './func/writeQAServiceContent.php';
            $result = writeQAServiceContent($login_token,$oid,$qa_content,$is_send,$qa_status,$connect);
            echo json_encode($result);   
        break;
       
    case 'checkUpdateQAFiles':
            $upload = $_FILES['upload'];
            include './func/writeQAFiles.php';
            $result = writeQAFiles($login_token,$upload,$connect);
            echo json_encode($result);   
        break;
    
    case 'checkUpdateQACContent'://未完成、未測試
            $oid = $_POST['oid'];//會用正則表達確認資料，不用跳脫
            $qa_content = htmlspecialchars($_POST['qaContent']);
            $qa_files = '';
            if($_FILES){
                $qa_files = $_FILES['qaFiles'];
            }
            include './func/writeQACustomerContent.php';
            $result = writeQACustomerContent($login_token,$oid,$qa_content,$qa_files,$connect);
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