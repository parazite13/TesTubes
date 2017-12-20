<?php

$ajax='';
require '../init.php';

$insert = 
	array(
		'date' => date("Y-m-d H:i:s"),
		'id_user' => intval($_SESSION['id']),
		'id_video' => intval($_GET['id_video']),
		'comment' => $_GET['comment']
	);	

$mongoDb->getComments()->insertOne($insert);
?>