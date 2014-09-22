<?php

     // change to your ip cluster
     $ip = "192.168.0.2";      
     $pingresult = exec("/bin/ping -c2 -w2 $ip", $outcome, $status);
     if (0 == $status) {
      	 $status = "running";
     } else {
      	    $status = "power off";
      	    }
     echo '[Cluster status: '.$status.']';
     
?>
