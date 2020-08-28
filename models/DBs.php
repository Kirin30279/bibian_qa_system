<?php

  namespace models\DB;
  
  use \PDO;

  include_once "/opt/html/bibian_qa_system/configs/secure_items.php";

  class Dbs {
    private $_pdo;
    private $_dbIP = DBIP;
    private $_systemLog;
    /**
     *  初始化，連線資料庫
     */
    function __construct($params = array()) {
      $databases = "japanim_main";
      $username = DBACCOUNT;
      $password = DBPASSWD;

      if(isset($params['dbdb']) && $params['dbdb']) {
        $databases = $params['dbdb'];
      }
      
      if(isset($params['username']) && $params['username']) {
        $username = $params['username'];
      }

      if(isset($params['password']) && $params['password']) {
        $password = $params['password'];
      }

      $dsn = 'mysql:dbname='.$databases.';host='.$this->_dbIP;

      try {
        $this->_pdo = new \PDO($dsn, $username, $password);
        $this->_pdo ->exec("set names utf8");
      } catch (PDOException $e) {
        printf("DatabaseError: %s ", $e->getMessage());
      }

      $this->_systemLog = new \Libs\SL\SystemLog();
    }

    /**
     *  檢查是否有不可運行的關鍵字
     *  @params String  $sql  SQL語法，要做檢查用
     */
    private function _checkSqlHasIllegal($sql = "") {
      // 針對密碼欄位
      if(preg_match('/pass_mbr/isU', $sql)) {
        // 允許的網址路徑有
        if(preg_match('/\/line_binding\/testPush/isU', $_SERVER["PHP_SELF"])) {
          // nothing to do
        } else {
          return true;
        }
      }

      return false;
    }

    /**
     *  處理select sql語法
     *  @params String  $sql    SQL語法，where部分請帶?
     *  @params Array   $data   帶入查詢的值
     */
    function execGetSQL($sql = "", $data = []) {
      // sql檢查
      if($this->_checkSqlHasIllegal($sql)) {
        return [];
      };

      // 取得資料
      $stmt = $this->_pdo->prepare($sql);
      $stmt->execute($data);
      $stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $this->_systemLog->recordSQLData($sql, $data);
      
      return $stmt;
    }

    /**
     *  處理insert/update sql語法
     *  @params String  $sql    SQL語法，where部分請帶?
     *  @params Array   $data   帶入增加/更新的值
     */
    function execSetSQL($sql = "", $data = []) {
      // sql檢查
      if($this->_checkSqlHasIllegal($sql)) {
        return [];
      };

      // 增加/更新資料
      $stmt = $this->_pdo->prepare($sql);
      $stmt = $stmt->execute($data);

      $this->_systemLog->recordSQLData($sql, $data);

      return $stmt;
    }
  }

?>