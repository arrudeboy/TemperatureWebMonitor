<?php
$value = $_POST['limitTemp'];
$HANDLE = fopen('config/limitTemp.config', 'w') or die ('CANT OPEN FILE');
fwrite($HANDLE,$value);
fclose($HANDLE);
?>
