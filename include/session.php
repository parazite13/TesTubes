<?php
	session_start();

	//l'utilisateur se déconnecte
	if(isset($_POST['disconnect'])){
		session_destroy();

		// Corrige le bug de retransmission du formulaire
		header("Location: " . ABSURL);
		exit;
	}

	if(!isset($_SESSION['connect'])) $_SESSION['connect'] = false;

	//la personne s'est inscrite
	if(isset($_POST['username-inscr'] , $_POST['pwd-inscr'])){
		//inclut l'utilisateur dans les users
		$array = array( 'pseudo' => $_POST['username-inscr'], 
						'password' => md5($_POST['pwd-inscr']),
						'api_key' => null
					);
		$db->insertInto('users', $array);
		$id = $db->getLastInsertId();
		//inclut des pref par défaut dans les prefs
		$arrayPref = array( 'id_user' => $id, 
							'titre' => 1,
							'auteur' => 1,
							'vues' => 1,
							'date' => 1,
							'description' => 1,
							'duree' => 1
						);
		$db->insertInto('preferences', $arrayPref);
		//inclut des pref par défaut dans les prefs des auteurs
		$arrayPrefAuthor = array( 'id_user' => $id, 
							'titre' => 1,
							'videos' => 1,
							'date' => 1,
							'description' => 1
						);
		$db->insertInto('preferences_author', $arrayPrefAuthor);
		//connecte l'utilisateur quand il s'inscrit
		$_POST['username-con'] = $_POST['username-inscr'];
		$_POST['pwd-con'] = $_POST['pwd-inscr'];

	}

	//la personne essaie de se connecter
	if(isset($_POST['username-con'], $_POST['pwd-con'])){

		$user = $db->getRowFromQuery('SELECT * FROM `users` WHERE `pseudo`=\'' . $_POST['username-con'] . '\'');
		if(md5($_POST['pwd-con']) == $user['password']){
			$_SESSION['connect'] = true;
			$_SESSION['pseudo'] = $user['pseudo'];
			$_SESSION['id'] = $user['id'];
			$_SESSION['api_key'] = $user['api_key'];
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
