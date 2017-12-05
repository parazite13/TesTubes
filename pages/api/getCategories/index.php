<?php

header('Content-Type: application/json');
echo json_encode($api->getCategories(), JSON_PRETTY_PRINT);

?>