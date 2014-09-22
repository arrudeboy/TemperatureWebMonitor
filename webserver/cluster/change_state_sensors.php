<?php

$command = $_POST['command'];
$path_to_file = '../config/sensors_states.config';        

if ($command == "1"){
	//enable sensor 1
	$file_contents = file_get_contents($path_to_file);
	$file_contents = str_replace("s1=0","s1=1",$file_contents);
	file_put_contents($path_to_file,$file_contents);
}
else if($command == "2"){
	//disable sensor 1
	$file_contents = file_get_contents($path_to_file);
	$file_contents = str_replace("s1=1","s1=0",$file_contents);   
	file_put_contents($path_to_file,$file_contents);
}
else if($command == "3"){                                                         
        //enable sensor 2                                                
	$file_contents = file_get_contents($path_to_file);
        $file_contents = str_replace("s2=0","s2=1",$file_contents);   
        file_put_contents($path_to_file,$file_contents);
}                                 
else if($command == "4"){                                                         
        //disable sensor 2                                                
	$file_contents = file_get_contents($path_to_file);
	$file_contents = str_replace("s2=1","s2=0",$file_contents);   
	file_put_contents($path_to_file,$file_contents);
}
else if($command == "5"){                                                         
        //enable sensor 3                                                
	$file_contents = file_get_contents($path_to_file);
        $file_contents = str_replace("s3=0","s3=1",$file_contents);   
	file_put_contents($path_to_file,$file_contents);
}
else if($command == "6"){                                                         
        //disable sensor 3                                                

	$file_contents = file_get_contents($path_to_file);
	$file_contents = str_replace("s3=1","s3=0",$file_contents);   
	file_put_contents($path_to_file,$file_contents);
} 
                                                                                      
?>
