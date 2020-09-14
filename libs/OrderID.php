<?php
class NumberPOST 
{
    public $content;
    public $illegal;
    public $error_message;
    private $format = "/^[0-9]*$/";
    public function __construct($number){
        $this->content  = $number;
        $preg_format = $this->getFormat();
        if(!preg_match($preg_format,$number)){
            $this->illegal = true;//不合格式
            $this->error_message = "輸入不合格式"; 
        } else{
            $this->illegal = false;//符合格式
        }
    }
 
    public function getFormat(){
        return $this->format;
    }


}

class OrderId extends NumberPOST
{
    private $format = "/^[0-9]{10}$/";
    public function __construct($oid){
        parent::__construct($oid);
    }

    public function getFormat(){
        return $this->format;
    }
    
}

class IsSend extends NumberPOST
{
    private $format = "/^[0-1]$/";
    public function __construct($issend){
        parent::__construct($issend);
    }
    
    public function getFormat(){
        return $this->format;
    }
}

class QAStatus extends NumberPOST
{
    private $format = "/^[0-1]$/";
    public function __construct($issend){
        parent::__construct($issend);
    }
    
    public function getFormat(){
        return $this->format;
    }
}