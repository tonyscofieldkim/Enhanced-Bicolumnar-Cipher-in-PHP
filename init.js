$(document).ready(function(){
//operarion mode property

jQuery.ebcMode={advanced:false};
$('#op-mode').on('click',function(){
     $.ebcMode.advanced=$(this).prop('checked');
});
//a handler to report request
 
//sideNav
$(".button-collapse").sideNav();

var reportXhrErr= function(){

alert("Network error report\nRequest:"+$.lastXhrError.resource+"\nresponse Code:"+$.lastXhrError.code+"\nError caught:"+$.lastXhrError.error+"\n\nResponse:\n"+$.lastXhrError.response+"\nAt :"+$.lastXhrError.atTime);
}


var date;
//lets keep last ajax error globally.
jQuery.lastXhrError={resource:"unspecific",code:404,response:"no response" ,error:"Failed to load for some reason",atTime:''};
var initData=false;

//global ajax settings
$(this).ajaxError(function(event,jqxhr,settings,thrownError){
alert(jqxhr.responseText);
Materialize.toast('<p>Sorry, a network error occured try reloading the page <a onclick="reportXhrErr()" href="#!">Details?</a></p>',60000);
console.log('failed to load '+settings.url+' The error cauaght ="'+thrownError+'"');

date=new Date();
$.lastXhrError.resource=settings.url;
$.lastXhrError.code=jqxhr.status;
$.lastXhrError.error=thrownError;
$.lastXhrError.response=jqxhr.responseText;
$.lastXhrError.atTime=date.toTimeString();

});//ajax err

$(this).ajaxSuccess(function(event,jqxhr,settings){

console.log('Done loading '+settings.url);
});//ajax success

//check key&&input
$("#encrypt").on('click',function(){
var inpuut=$("#input").val();
var keey=$("#key").val();
var opMode=$.ebcMode.advanced;

//send post request
$.post("ebc_demo.php" , 

{action:"encrypt",key:keey,input:inpuut,opmode:opMode},function(output){
if(output.error){
Materialize.toast('<p>'+output.error+'</p>',10000);
return;
}
//show output.
if(output.solution){
//alert(output.solution);
$('#output').empty();
var i=0;var txt;
var Estream=function(){

setTimeout(function(){
if(i>=output.solution.length){
return;
}
else{
txt=$("#output").text();
$("#output").text(txt+""+output.solution[i]);
i++;
Estream();
}

},16);
};
Estream();

}

},'json');

});//
$("#decrypt").on('click',function(){
var inpuut=$("#input").val();
var keey=$("#key").val();
var opMode=$.ebcMode.advanced;

//post
$.post("ebc_demo.php" , 

{action:"decrypt",key:keey,input:inpuut,opmode:opMode},function(output){
if(output.error){
Materialize.toast('<p>'+output.error+'</p>',10000);
return;
}
//show output.
if(output.solution){
$('#output').empty();
var i=0;var txxt;
var Dstream=function(){

setTimeout(function(){
if(i>=output.solution.length){
return;
}
else{
txxt=$("#output").text();
$("#output").text(txxt+""+output.solution[i]);
i++;
Dstream();
}
},16);
};
Dstream();

}

},'json');

});
//copy-to-in on click
$("#out-to-in").on("click",function(){

var out=$("#output").text();
$("#output").empty();

$("#input").val(out);

Materialize.updateTextFields();
});

$("#clear-fields").on('click',function(){
$("#output").empty();
$("#input").val("");
$("#key").val('');
Materialize.updateTextFields();

});


});//jq ready()
