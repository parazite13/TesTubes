<?php
	session_start();

	//la personne (admin) se déconnecte
	if(isset($_POST['disconnect'])){
		session_destroy();

		// Corrige le bug de retransmission du formulaire
		header("Location: " . ABSURL);
		exit;
	}

	if(!isset($_SESSION['connect'])) $_SESSION['connect'] = false;


	//la personne essaie de se connecter
	if(isset($_POST['pwd-con'])){

		$user = $db->getRowFromQuery('SELECT * FROM `users` WHERE `pseudo`=\'' . $_POST['username-con'] . '\'');
		if(md5($_POST['pwd-con']) == $user['password']){
			$_SESSION['connect'] = true;
			$_SESSION['pseudo'] = $user['pseudo'];
			if(isset($_POST['request_url'])){
				header('Location: ' . $_POST['request_url']);
				exit;
			}
		}else{
			$_SESSION['alertPwd'] = true;
		}

		// Corrige le bug de retransmission du formulaire
		header("Location: " . ABSURL);
		exit;
	}
?>