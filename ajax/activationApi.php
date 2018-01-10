<?php

$ajax='';
require '../init.php';

$apiKey = "";
if(isset($_GET['activation'], $_SESSION['connect'])){

	if($_GET['activation'] == "true"){
		$apiKey = md5($_SESSION['pseudo']);
		$db->executeQuery("UPDATE `users` SET `api_key` = '".$apiKey."' WHERE `users`.`id` = ".$_SESSION['id'].";");
	}else{
		$db->executeQuery("UPDATE `users` SET `api_key` = NULL WHERE `users`.`id` = ".$_SESSION['id'].";");
	}
}

echo $apiKey;

?>