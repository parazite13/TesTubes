<?php

$category = isset($_GET['category']) ? $_GET['category'] : 0;
$problem = isset($_GET['problem']) ? $_GET['problem'] : 0;

header('Content-Type: application/json');
echo json_encode($api->getQuestions($category, $problem), JSON_PRETTY_PRINT);

?>