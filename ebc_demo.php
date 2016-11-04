<?php


$output=array('error'=>'!--error,make this request using post--','solution'=>false);

if($_SERVER['REQUEST_METHOD'] =="POST"){

if( isset($_POST['input'])&&isset($_POST['key'])&&isset($_POST['action']) &&isset($_POST['opmode'])  ){

if(!empty($_POST['input'])&&!empty($_POST['key'])&&!empty($_POST['action'])){


require_once("EBC/ebc_functions.php");
$key=$_POST['key'];
$input=$_POST['input'];
$action=trim($_POST['action']);

if(strlen($key) <6 ){

header("Content-type:application/json");
exit(json_encode(array('error'=>"!--error, the key provided is too short use six or more characters--",'solution'=>false)));
}
$modes=array('true','false');
$opmode=$_POST['opmode'];
if(!in_array($opmode,$modes)){

header("Content-type:application/json");
exit(json_encode(array('error'=>"!--error, operation mode is not specified--",'solution'=>false)));
}
//if encrypt
if($action=="encrypt"){

if($opmode=='false'){
$output['solution']=ebc_encrypt($input,$key,false);
$output['error']=false;
}
if($opmode=="true"){
$output['solution']=ebc_encrypt($input,$key,true);
$output['error']=false;
}


}
//if decrypt
if($action=="decrypt"){

if($opmode=="false"){
$output['solution']=ebc_decrypt($input,$key,false);
$output['error']=false;
}
if($opmode=="true"){
$output['solution']=ebc_decrypt($input,$key,true);
$output['error']=false;
}

}

}else $output['error']="!--error some inputs are empty.--";

}else $output['error']="!--Error! Some inputs are missing--";
}//else not post

//send headers
header("Content-type:application/json");

exit(json_encode($output));

?>