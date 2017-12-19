<?php

$ajax='';
require '../init.php';

$port = $_POST['port'];
$array = array();
$output = "";

exec('WMIC path win32_process get Caption,Processid,Commandline', $array, $output);

$matches;
foreach($array as $process){
	if(preg_match('/(vlc\.exe).*(dst=:'.$port.').* ([0-9]+)$/', $process, $matches)){
		$pid = $matches[3];
		$cmd = 'taskkill /pid '.$pid.' /F';
		exec($cmd);
	}
}


?>