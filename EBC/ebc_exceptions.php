<?php
class EBC_invalidParam extends Exception{

public function __construct($message,$code=0,Exception $previous=null){

$_message=ucfirst($message);
parent::__construct($_message,$code,$previous);
}
public function __toString(){
return 'Fatal Error! ' ."({$this->getCode()}):{$this->getMessage()} ;In  {$this->getFile()} on line {$this->getLine()} Trace: {$this->getTraceAsString()}.";
}

}
