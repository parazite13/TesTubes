<?php

$ajax='';
require '../init.php';

$insert = 
	array(
		'date' => date("Y-m-d H:i:s"),
		'time_video' => intval($_GET['chrono']),
		'id_user' => intval($_SESSION['id']),
		'id_video' => $_GET['id_video'],
		'comment' => $_GET['comment']
	);	

$mongoDb->getComments()->insertOne($insert);
?>