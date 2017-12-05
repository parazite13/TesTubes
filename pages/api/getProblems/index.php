<?php

$category = isset($_GET['category']) ? $_GET['category'] : 0;

header('Content-Type: application/json');
echo json_encode($api->getProblems($category), JSON_PRETTY_PRINT);

?>