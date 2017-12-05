<?php

header('Content-Type: application/json');
echo json_encode($api->getPreferences(), JSON_PRETTY_PRINT);

?>