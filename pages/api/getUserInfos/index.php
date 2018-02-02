<?php

try{
	$content = $api->getUserInfos();
	header('Content-Type: application/json');
	echo json_encode($content, JSON_PRETTY_PRINT);
}catch(Exception $exception){
	echo "Exception: API request need api_key !!";
}

?>