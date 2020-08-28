<?php

  namespace Models\LM;

  use models\DB;

  class Members {
    private $_dbs;
    
    function __construct($params = array()) {
      $this->_dbs = new DB\Dbs(array("dbdb" => ""));
    }
  }

?>