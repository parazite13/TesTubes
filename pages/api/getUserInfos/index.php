<?php

header('Content-Type: application/json');
echo json_encode($api->getUserInfos(), JSON_PRETTY_PRINT);

?>