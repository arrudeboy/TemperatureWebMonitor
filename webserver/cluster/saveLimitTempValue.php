<?php
$value = $_POST['limitTemp'];
$HANDLE = fopen('limitTemp.config', 'w') or die ('CANT OPEN FILE');
fwrite($HANDLE,$value);
fclose($HANDLE);
?>
