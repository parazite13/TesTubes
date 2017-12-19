<?php

$video = isset($_GET['video']) ? $_GET['video'] : 0;

header('Content-Type: application/json');
echo json_encode($api->getComments($video), JSON_PRETTY_PRINT);

?>