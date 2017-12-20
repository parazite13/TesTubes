<?php

$ajax='';
require '../init.php';

$insert = 
	array(
		'date' => date("Y-m-d H:i:s"),
		'id_user' => $_SESSION['id'],
		'id_video' => $_GET['id_video'],
		'comment' => $_GET['comment']
	);	

$mongoDb->getComments()->insertOne($insert);
?>