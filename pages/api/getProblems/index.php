<?php

try{
	$category = isset($_GET['category']) ? $_GET['category'] : 0;
	$content = $api->getProblems($category);
	header('Content-Type: application/json');
	echo json_encode($content, JSON_PRETTY_PRINT);
}catch(Exception $exception){
	echo "Exception: API request need api_key !!";
}
?>