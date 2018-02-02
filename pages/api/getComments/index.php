<?php

try{
	$video = isset($_GET['video']) && $_GET['video'] != "null" ? $_GET['video'] : null;
	$content = $api->getComments($video);
	header('Content-Type: application/json');
	echo json_encode($content, JSON_PRETTY_PRINT);
}catch(Exception $exception){
	echo "Exception: API request need api_key !!";
}
?>