<?php
$emails = "";
$HANDLE = fopen('config/admin_emails.config', 'w') or die ('CANT OPEN FILE');
if ($_POST['email1'] != "")
	$emails = $_POST['email1'];
if ($_POST['email2'] != "")
	$emails .= "\n" . $_POST['email2'];
if ($_POST['email3'] != "")	
	$emails .= "\n" . $_POST['email3'];
if ($_POST['email4'] != "")
	$emails .= "\n" . $_POST['email4'];
	
fwrite($HANDLE,$emails);
fclose($HANDLE);
		
?>
