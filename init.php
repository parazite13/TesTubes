<?php

// Chemin absolu vers le dossier racine
define('ABSPATH', dirname(__FILE__)  . "/");

// Initialise la configuration de base
require(ABSPATH . 'include/config.php');

// Charge toutes les classes récursivement
require(ABSPATH . 'include/classLoader.php');

// Charge les classes de composer
require(ABSPATH . 'vendor/autoload.php');

// Création de l'objet de connexion à la base de données
$db = new Db(DB_NAME);
$mongoDb = new MongoDb(DB_NAME);


echo '<pre>';


/*
echo '<pre>';

$insert = 
	array(
		'id' => 4,
		'enonce' => "The term Big Data first originated from ?",
		'reponses' => array(
			'A' => "Stock Markets Domain",
			'B' => "Banking and Finance Domain",
			'C' => "Genomics and Astronomy Domain",
			'D' => "Social Media Domain"
		),
		'correct' => 'C'
	);	

//$mongoDb->getQuestions()->insertOne($insert);
//$mongoDb->getQuestions()->deleteOne(array("id" => 3));
//$results = $mongoDb->getQuestions()->find(array(), array("summary" => true))->toArray();
*/
/*
$insert = 
	array(
		'id' => 1,
		'questions' => array(
			1, 
			2, 
			3, 
			4, 
			5
		)
	);	

//$mongoDb->getQuiz()->insertOne($insert);

$results = $mongoDb->getQuiz()->find(array(), array("summary" => true))->toArray();
*/

//print_r($results);
die();


// Initialise les variables de session
require(ABSPATH . 'include/session.php');

// Charge les fonctions utiles
require(ABSPATH . 'include/functions.php');

// Charge la page demandé par l'utilisateur
if(!isset($ajax)){
	require(ABSPATH . 'include/dispatcher.php');
}
?>