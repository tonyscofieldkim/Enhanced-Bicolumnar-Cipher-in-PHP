<?php
/**@file ebc_functions.php
**@author Tony Kimari
**@description --This file contains two functions as interface to the _EBC class. 
*the two functions  instantiate the _EBC class twice with the same key while 
*where the next instance uses the output of the first instance.
*the reason for the double instance is to make it achieve bicolumnar cipher,this means we could as well make triple instances to make it tricolumnar if we want.
*@see ebc.php
*@licence MIT
***/
require_once("CLASS/ebc.php");
require_once("CLASS/ebc_exceptions.php");

function ebc_encrypt($plain=false,$key=false,$advanced=false){
$plainT=$plain;
try{
$ordShift=0;
$text2;
$cipher;
//get the new key from the key provided

//get ordinal shif value from the key, if in advance mode
/**if($advanced==true){
$char1=$key[0];
$ordVal=ord($char1);
if($ordVal<1){
$ordVal=1;
}
$ordShift = fmod(513,$ordVal);
//return $ordShift;
}
$plainIn="";

//shift characters
$i; 
for($i=0;$i< strlen($plainT);$i++){
$charToShift=$plainT[$i];
$ordToShift=ord($charToShift);
$newOrd=$ordToShift+$ordShift;

$chrr=chr($newOrd);
$plainIn.=$chrr;

}
return $plainIn;

*/
$tire1=new _EBC($plainT,$key,_EBC::ENCRYPT);
$cp1 = $tire1->solve();
$tire1=null;



$tire1=new _EBC(strrev($key),$key,_EBC::ENCRYPT);
$newKey=$tire1->solve();


$tire2=new _EBC($cp1,$newKey,_EBC::ENCRYPT);
$cipher= $tire2->solve();

$tire2=null;
return $cipher;
}
catch(EBC_invalidParam $e){
exit($e);
}


}


function ebc_decrypt($cipher=false,$key=false,$advanced=false){

try{

$plain;


$tire1=new _EBC(strrev($key),$key,_EBC::ENCRYPT);
$key1 = $tire1->solve();
$tire1=null;
$tire1=new _EBC($cipher,$key1,_EBC::DECRYPT);
$pt1= $tire1->solve();


$tire2=new _EBC($pt1,$key,_EBC::DECRYPT);
$plain= $tire2->solve();



return str_replace($tire2->_dontCare,"",$plain);
}
catch(EBC_invalidParam $e){
exit($e);
}


}//end of class and file.