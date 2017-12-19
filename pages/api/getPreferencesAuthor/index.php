<?php

header('Content-Type: application/json');
echo json_encode($api->getPreferencesAuthor(), JSON_PRETTY_PRINT);

?>