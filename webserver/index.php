<head>
   
    <script type="text/javascript" src="zepto.min.js"></script>
    <script type="text/javascript" src="scripts.js"></script>
     
</head>
<body onload="setInterval(refresh, 1000);"> 
      
     <?php require('getAdminEmails.php'); 
     
      $file = fopen('limitTemp.config', 'r') or die ('CANT OPEN FILE');
      
      $array = array();
      
      while(!feof($file)){
          $line = fgets($file);
          $array[] = $line;
      }
      $max_temperature_value = floatval($array[0]);         
      fclose($file);
      ?>      
      
      <h1> Temperature Web Monitor [Arduino Yun-90A2DAF50ED9] </h1>
      <div style="font-size:12px" id="clusterstatus"></div>
     
      </br>

      <p style="border:2px solid black; margin-left:60px; width:140px"> <b>ADMIN PANEL</b> </p>
      <p style="margin-left:180px"> [Cluster system options: ]</p>
      <div style="margin-left:220px">
      <button style="background-color:#FF6600" class="btn btn-block btn-lg btn-primary" type="button" id="7" onClick="clusterOptions(this.id)"> Reboot </button>
      <button style="background-color:#666699" class="btn btn-block btn-lg btn-primary" type="button" id="8" onClick="clusterOptions(this.id)"> Shutdown </button>
      </div>

      </br>

      <p style="margin-left:180px"> [Enable/Disable Sensors: ]</p>       	 
      <div style="margin-left:220px">
      <button style="background-color:lightgreen" class="btn btn-block btn-lg btn-primary" type="button" id="1" onClick="buttonClick(this.id)"> Enable S1 </button>	
      <button style="background-color:#FF3030" class="btn btn-block btn-lg btn-primary" type="button" id="2" onClick="buttonClick(this.id)"> Disable S1 </button>
      <button style="background-color:lightgreen" class="btn btn-block btn-lg btn-primary" type="button" id="3" onClick="buttonClick(this.id)"> Enable S2 </button>
      <button style="background-color:#FF3030" class="btn btn-block btn-lg btn-primary" type="button" id="4" onClick="buttonClick(this.id)"> Disable S2 </button>
      <button style="background-color:lightgreen" class="btn btn-block btn-lg btn-primary" type="button" id="5" onClick="buttonClick(this.id)"> Enable S3 </button>
      <button style="background-color:#FF3030" class="btn btn-block btn-lg btn-primary" type="button" id="6" onClick="buttonClick(this.id)"> Disable S3 </button>
	</div>

      </br>

      <p style="margin-left:180px"> [Max. Temperature Limit Sensors: ]</p>
      <div style="margin-left:220px">
      	<p><label>Temp. value: </label><input id="tempValue" max="85.00" value=<?php echo $max_temperature_value;?> type="number" step="00.25"/><button type="button" onClick="saveLimitTempValue()">Save</button></p>
      </div>

      </br>

      <p style="margin-left:180px"> [Phases: ]</p>
      <div style="margin-left:220px">
      	<p><label>Phase #1: </label><button id="btnPhase1en" disabled>ON</button>&nbsp;&nbsp;<button id="btnPhase1di" disabled>OFF</button></p>
      	<p><label>Phase #2: </label><button id="btnPhase2en" disabled>ON</button>&nbsp;&nbsp;<button id="btnPhase2di" disabled>OFF</button></p>
      	<p><label>Phase #3: </label><button id="btnPhase3en" disabled>ON</button>&nbsp;&nbsp;<button id="btnPhase3di" disabled>OFF</button></p>
      	<p><label>Alarm: </label><button id="btnAlarmEn" disabled>ON</button>&nbsp;&nbsp;<button id="btnAlarmDi" disabled>OFF</button></p>
      </div>

      </br> 

      <p style="margin-left:180px"> [Log contact emails: ]</p>
      <div style="margin-left:220px">
      <form name="myForm" action="" method="post">
           <p><label>Email #1: </label> <input type="text" name="email1" value=<?php echo $admin_email1;?>></p>
           <p><label>Email #2: </label> <input type="text" name="email2" value=<?php echo $admin_email2;?>></p>
           <p><label>Email #3: </label> <input type="text" name="email3" value=<?php echo $admin_email3;?>></p>
           <p><label>Email #4: </label> <input type="text" name="email4" value=<?php echo $admin_email4;?>></p>
      	   <button style="margin-left:170px" type="button" onClick="validateForm()">Save</button>
      </form>
      </div>
      
      
      <p style="margin-left:180px"> [Temperature Sensors: ]</p>	
      <span style="margin-left:220px" id="content">Waiting for Arduino...</span>
      
</body>
