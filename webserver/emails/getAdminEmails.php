<?php
$admin_email1 = "";
$admin_email2 = "";
$admin_email3 = "";
$admin_email4 = "";
$array = array();
$file = fopen('../config/admin_emails.config', 'r') or die ('CANT OPEN FILE');
while(!feof($file)){
    $line = fgets($file);
    $array[] = $line;
}
if(array_key_exists(0, $array)) 
    $admin_email1 = $array[0];
if(array_key_exists(1, $array))        
    $admin_email2 = $array[1];
if(array_key_exists(2, $array))        
    $admin_email3 = $array[2];
if(array_key_exists(3, $array))        
    $admin_email4 = $array[3];

fclose($file);

?>
