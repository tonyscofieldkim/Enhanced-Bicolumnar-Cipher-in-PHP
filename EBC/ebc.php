<?php


class _EBC
{
/**
*@file: ebc.php
*@module :_EBC
*@description: A php class that implements the bicolumnar encryption algorithm to encrypt and decrypt text, with some advancements here called
**'Advanced Bicolumnar Cipher'
*@usage+++++++++++++++++++
*
** handle= new _EBC(String text=false, String key=false,String char dontCare=chr(512));
*
** handle.encrypt();//to encrypt
**handle.decrypt(); //to decrypt.
*@args : 1 -text to operate on
*@args : 2- key to use
*@args:3- character to treat as insignificant, i.e, it must not be used in your plaintext 
*@author: Tony kimari
*@licence: MIT Licence

**/





private $_key;//the key fed into the engine

private $_text;//plaintext or ciphertext  to encrypt or decrypt
private  $_action=1;
public $_dontCare;
private $_eTable=array();
private $_dTable=array();

private $_eko="NULL";//your solution is finally  here 

/*constants*/
const ENCRYPT=1;
const DECRYPT=2;

public function __construct($a=false,$b=false,$c=1){

$this->_dontCare=chr(512);
if(!$a||empty($a)){
throw new EBC_invalidParam("Empty parameters,usage :_EBES(String Text,String Key, Char dontCare).",1);
}
else $this->_text=$a;

if(!$b||empty($b)){
throw new EBC_invalidParam("Empty parameter b. b (text) required.",2);
}
else $this->_key=$b;

if(!$c ||!filter_var($c,FILTER_VALIDATE_INT) ||$c>2||$c<1){
throw new EBC_invalidParam("Invalid param c. use _EBC::ENCRYPT or _EBC::DECRYPT",3);

}
else $this->_action=$c;
 



if(strlen($this->_key)<6)throw new EBC_invalidParam('The key provided is too short,Keys should be composed by 6 or more chararacters',4);



if($this->_action==1){
$this->_init_cipher_blocks($this->_calculate_blocks());

$this->_eko=$this->_encrypt();
}
if($this->_action==2){
$this->_init_decipher_blocks($this->_calculate_blocks());

$this->_eko=$this->_decrypt();

}

}//construct
//the function to call when you need the solution
public function solve(){
return $this->_eko;
}
public function __toString(){
return "{$this->_eko}";
}

private  function   _calculate_blocks(){

$keysize=strlen($this->_key);

$text_size=strlen($this->_text);
$blocks=1;
if($text_size > $keysize){
$blocks= ceil($text_size/$keysize);

}
return $blocks;

}//calc func

private function _init_cipher_blocks($number){
$i;$n=$number;
for($i=0;$i<$n;$i++){
$this->_eTable[$i]=array();
}




//set character position in $_text 

$nthChar=0;$x=0;
//make the string an array.
$arrText=str_split($this->_text);
//iterate cipher table
for($i=0;$i<$n;$i++){
//fill inner array.
for($x=0;$x< strlen($this->_key);$x++){


//if string pointer is false, it means we just depleted our input text.
if(!array_key_exists($nthChar,$arrText)){
$char=$this->_dontCare;
}
else{
$char=$arrText[$nthChar];
}

$this->_eTable[$i][$x]=$char;

//increment $nthChar
$nthChar++;
}

}


}//init cipher-blocks

private function _init_decipher_blocks($number){

for($i=0;$i<$number;$i++){
$this->dTable[$i]=array();

}
//fill with dont cares first.
$z;
for($i=0;$i<$number;$i++){
for($z=0;$z < strlen($this->_key);$z++){
$this->_dTable[$i][$z]=$this->_dontCare;
}

}


}//_init_decipher_blocks

private function _encrypt(){


//a sorting function not using it for now..
if(!function_exists("sorter")){

function sorter($a,$b){
$ordA=ord($a[0]);
$ordB=ord($b[0]);
if($ordA < $ordB){
return -1;
}
if($ordA > $ordB){
return 1;
}
if($ordA==$ordB){
return -1;
}




}
}
//define our key as an array
$key=str_split($this->_key);
//sort this key
natsort($key);
//key is sorted and associated key=>value maintained.
$finalCipher='';
$n=0;

foreach($key as $kNth=>$val){

for($n=0;$n < count($this->_eTable);$n++){

$finalCipher.=$this->_eTable[$n][$kNth];


}


}

return $finalCipher;


}//encrypt

private function _decrypt(){


//a sorting function not in use, just here for convinience.
if(!function_exists("esorter")){

function esorter($a,$b){
$ordA=ord($a[0]);
$ordB=ord($b[0]);
if($ordA < $ordB){
return -1;
}
if($ordA > $ordB){
return 1;
}
if($ordA==$ordB){
return -1;
}




}
}



$keyAsR=str_split($this->_key);
natsort($keyAsR);
$cipher=str_split($this->_text);
$cipherPointer=0;$char=$this->_dontCare;
foreach($keyAsR as $k=>$v){

for($i=0;$i< count($this->_dTable);$i++){
if(array_key_exists($cipherPointer,$cipher)){
$char=$cipher[$cipherPointer];
}
$this->_dTable[$i][$k]=$char;
$cipherPointer++;
}

}//each keyAsR

//decrypt now...
$finalText='';
for($i=0;$i< count($this->_dTable);$i++){
for($z=0;$z< strlen($this->_key);$z++){
$finalText.=$this->_dTable[$i][$z];
}

}
return $finalText;

}//decrypt
}
//this line is the end of file..no ? >.