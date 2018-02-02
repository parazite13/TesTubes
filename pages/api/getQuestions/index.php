<?php
try{
	$category = isset($_GET['category']) ? $_GET['category'] : 0;
	$problem = isset($_GET['problem']) ? $_GET['problem'] : 0;
	$content = $api->getQuestions($category, $problem);
	header('Content-Type: application/json');
	echo json_encode($content, JSON_PRETTY_PRINT);
}catch(Exception $exception){
	echo "Exception: API request need api_key !!";
}
?>