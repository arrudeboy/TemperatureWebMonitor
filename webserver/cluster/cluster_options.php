<?php

$option = $_POST['command'];

if ($option == "7"){
	$output = exec('sshpass -p "mypasswd" ssh root@192.168.0.2 "/sbin/reboot"');
}
else if ($option == "8"){
	$output = exec('sshpass -p "mypasswd" ssh root@192.168.0.2 "/sbin/halt"');
}

?>
