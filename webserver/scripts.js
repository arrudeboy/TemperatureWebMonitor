function validateForm() {
         
         for (i=1; i<5; i++){
         	var id_em = "email" + i.toString();
         	var x = document.forms["myForm"][id_em].value;
         	var atpos = x.indexOf("@");
         	var dotpos = x.lastIndexOf(".");
         	if ((x != "") && (atpos< 1 || dotpos<atpos+2 || dotpos+2>=x.length)){
                      alert("Not a valid e-mail address");
                      return false;
         	}
         
         }
         var email1 = document.forms["myForm"]["email1"].value;
         var email2 = document.forms["myForm"]["email2"].value;
         var email3 = document.forms["myForm"]["email3"].value;
         var email4 = document.forms["myForm"]["email4"].value;
         var formData = "email1="+email1+"&email2="+email2+"&email3="+email3+"&email4="+email4;
         $.ajax({
         	url : "emails/saveEmails.php",
         	type : "POST",
         	data : formData,
         	success : function(data, textStatus, jqXHR)
         	{
         	  alert("Emails saved successfully.");
         	},
         });
                           
}                                                                                   
       
function saveLimitTempValue(){
                                                                                                                   
	var temp = document.getElementById('tempValue').value;                                                                                
        var tdata="limitTemp="+temp;                                                                                                                                                                                                                       
        	$.ajax({
        		url: "cluster/saveLimitTempValue.php",
        		type: "POST",
        		data: tdata,
  			success : function(data,textStatus,jqXHR)
  			{
  				alert('Max. Temperature value sensors have been updated');        		
			},        
		});        
} 

function refresh() {
	$('#content').load('/arduino/temperature');
}    
        
function clusterOptions(clicked_id){
        
	if (clicked_id == "7"){
		var r = confirm("Are you sure that you want to reboot the system cluster now?");
        	if (r == true) {
        	      alert("The cluster system will be reboot now...");
        	      $.post( "cluster/cluster_options.php", {    
        	      command: "7"} );
        	} 
       	}
       	if (clicked_id == "8"){
        		
       		var r = confirm("Are you sure that you want to shutdown the system cluster now?");
       		if (r == true) {                          
       	            alert("The cluster system will be reboot now...");
       	            $.post( "cluster/cluster_options.php", {                         
        	            command: "8"} );                                                  
       	        } 
        	
        }
}

function buttonClick(clicked_id){

	if (clicked_id == "1"){
		alert("Sensor 1 has been ENABLED");
      		$.post( "cluster/change_state_sensors.php", {
        		command: "1"} );
    	}
    	if (clicked_id == "2"){
        	alert("Sensor 1 has been DISABLED");
       		$.post( "cluster/change_state_sensors.php", {
        		command: "2"} );
    	}
    	if (clicked_id == "3"){
    		alert("Sensor 2 has been ENABLED");
    		$.post( "cluster/change_state_sensors.php", {
    			command: "3"} );
    	}
    	if (clicked_id == "4"){
    		alert("Sensor 2 has been DISABLED");
    		$.post( "cluster/change_state_sensors.php", {
    			command: "4"} );
    	}
    	if (clicked_id == "5"){
    		alert("Sensor 3 has been ENABLED");
    		$.post( "cluster/change_state_sensors.php", {
    			command: "5"} );
   	}
  	if (clicked_id == "6"){
  		alert("Sensor 3 has been DISABLED");
  		$.post( "cluster/change_state_sensors.php", {
    			command: "6"} );
  	}
                                                                                         
}
    	
$(function() {
    	  
	getStatus();     	      
});
       
    	       
function getStatus() {
    	        
     $('div#clusterstatus').load('cluster/getclusterstatus.php');
    	     
     setTimeout("getStatus()",10000);
    	                 
}

function readPhasesAndAlarm(alarm,phase1,phase2,phase3){	

	if (alarm == "0"){
		document.getElementById("btnAlarmEn").style.background='#FFFFFF';                                                                              
		document.getElementById("btnAlarmDi").style.background='#FF0000';                                                                              
	}
	else if (alarm == "1"){
		      document.getElementById("btnAlarmEn").style.background='#009933';                                                                              
	        document.getElementById("btnAlarmDi").style.background='#FFFFFF';
	        alert('Alarm is warning!\nThe system cluster will be shutting down now for avoid device damages.');
	        $.post( "cluster/cluster_options.php", {                                                                                     
		                 command: "8"} ); 
 	
	}
	if (phase1 == "0"){
		document.getElementById("btnPhase1en").style.background='#FFFFFF';                                                                             
	  document.getElementById("btnPhase1di").style.background='#FF0000';       			
	}
	else if (phase1 == "1"){
		document.getElementById("btnPhase1en").style.background='#009933';                                                                             
	  document.getElementById("btnPhase1di").style.background='#FFFFFF';             			
	}
	if (phase2 == "0"){
		document.getElementById("btnPhase2en").style.background='#FFFFFF';                                                                             
		document.getElementById("btnPhase2di").style.background='#FF0000'; 
	}
	else if(phase2 == "1"){
		document.getElementById("btnPhase2en").style.background='#009933';                                                                             
	  document.getElementById("btnPhase2di").style.background='#FFFFFF';  		
	}
	if (phase3 == "0"){
		document.getElementById("btnPhase3en").style.background='#FFFFFF';                                                                             
		document.getElementById("btnPhase3di").style.background='#FF0000'; 
	}
	else if (phase3 == "1"){
		document.getElementById("btnPhase3en").style.background='#009933';                                                                             
		document.getElementById("btnPhase3di").style.background='#FFFFFF';  
	} 		                                                                                                          	             
}
