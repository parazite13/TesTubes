<?php

$ajax='';
require '../init.php';

$port = $_POST['port'];
$array = array();

// Traitement pour windows
if (substr(php_uname(), 0, 7) == "Windows"){ 

	exec('WMIC path win32_process get Caption,Processid,Commandline', $array);

	$matches;
	foreach($array as $process){
		if(preg_match('/(vlc\.exe).*(dst=:'.$port.').* ([0-9]+)$/', $process, $matches)){
			$pid = $matches[3];
			$cmd = 'taskkill /pid '.$pid.' /F';
			exec($cmd);
		}
	}
}else{

	exec('ps -ef', $array);

	$matches;
	foreach($array as $process){
		if(strpos($process, 'vlc ') !== false){
			preg_match('/([0-9])+/', $process, $matches);
			$pid = $matches[1];
			$cmd = 'kill -9 ' . $pid;
			exec($cmd);
		}
	}
}

?>