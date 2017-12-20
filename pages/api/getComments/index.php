<?php

$video = isset($_GET['video']) && $_GET['video'] != "null" ? $_GET['video'] : null;

header('Content-Type: application/json');
echo json_encode($api->getComments($video), JSON_PRETTY_PRINT);

?>