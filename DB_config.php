<?PHP
$servername='localhost';//主機名稱
$username='root';//使用者名稱
$password='';//使用者PW
$dbname = "day5_qa";//DB名稱
$connect = new mysqli($servername,$username,$password,"$dbname");
  if ($connect->connect_error) {
    die("連線失敗: " . $connect->connect_error);
    }   
?>