<?php

$ajax='';
require '../init.php';

$insert = 
	array(
		'date' => date("Y-m-d H:i:s"),
		'id_user' => $_SESSION['id'],
		'comment' => $_GET['comment']
	);	

$mongoDb->getComments()->insertOne($insert);
?>