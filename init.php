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
/*
echo '<pre>';
//------- INSERT QUESTIONS ------- //
$insert = 
	array(
		'id' => 1,
		'enonce' => "What does commodity Hardware in Hadoop world mean?",
		'reponses' => array(	
			'A' => "Very cheap hardware",
			'B' => "Industry standard hardware",
			'C' => "Discarded hardware",
			'D' => "Low specifications Industry grade hardware"
		),
		'correct' => 'D',
		'problem' => 1, 
		'difficulty' => 1
	);	
$mongoDb->getQuestions()->insertOne($insert);
$insert = 
	array(
		'id' => 2,
		'enonce' => "Which of the following are NOT big data problem(s)?",
		'reponses' => array(	
			'A' => "Parsing 5 MB XML file every 5 minutes",
			'B' => "Processing IPL tweet sentiments",
			'C' => "Processing online bank transactions",
			'D' => "both (a) and (c)"
		),
		'correct' => 'D',
		'problem' => 1, 
		'difficulty' => 2
	);	
$mongoDb->getQuestions()->insertOne($insert);
$insert = 
	array(
		'id' => 3,
		'enonce' => "What does “Velocity” in Big Data mean?",
		'reponses' => array(	
			'A' => "Speed of input data generation",
			'B' => "Speed of individual machine processors",
			'C' => "Speed of ONLY storing data",
			'D' => "Speed of storing and processing data"
		),
		'correct' => 'D',
		'problem' => 1, 
		'difficulty' => 3
	);	
$mongoDb->getQuestions()->insertOne($insert);
$insert = 
	array(
		'id' => 4,
		'enonce' => "The term Big Data first originated from:",
		'reponses' => array(	
			'A' => "Stock Markets Domain",
			'B' => "Banking and Finance Domain",
			'C' => "Genomics and Astronomy Domain",
			'D' => "Social Media Domain"
		),
		'correct' => 'C',
		'problem' => 1, 
		'difficulty' => 4
	);
$mongoDb->getQuestions()->insertOne($insert);
$insert = 
	array(
		'id' => 5,
		'enonce' => "Which of the following Batch Processing instance is NOT an example of BigData Batch Processing?",
		'reponses' => array(
			'A' => "Processing 10 GB sales data every 6 hours",
			'B' => "Processing flights sensor data",
			'C' => "Web crawling app",
			'D' => "Trending topic analysis of tweets for last 15 minutes"
		),
		'correct' => 'D',
		'problem' => 1,
		'difficulty' => 5
	);
$mongoDb->getQuestions()->insertOne($insert);

$insert = 
	array(
		'id' => 6,
		'enonce' => "Which of the following are NOT true for Hadoop?",
		'reponses' => array(
			'A' => "It’s a tool for Big Data analysis",
			'B' => "It supports structured and unstructured data analysis",
			'C' => "It aims for vertical scaling out/in scenarios",
			'D' => "Both (a) and (c)"
		),
		'correct' => 'D',
		'problem' => 2,
		'difficulty' => 3
	);
$mongoDb->getQuestions()->insertOne($insert);

$insert = 
	array(
		'id' => 7,
		'enonce' => "Which of the following are the core components of Hadoop?",
		'reponses' => array(
			'A' => "HDFS",
			'B' => "Map Reduce",
			'C' => "HBase",
			'D' => "Both (a) and (b)"
		),
		'correct' => 'D',
		'problem' => 2,
		'difficulty' => 4
	);
$mongoDb->getQuestions()->insertOne($insert);

$insert = 
	array(
		'id' => 8,
		'enonce' => "Hadoop is open source.",
		'reponses' => array(
			'A' => "ALWAYS True",
			'B' => "True only for Apache Hadoop",
			'C' => "True only for Apache and Cloudera Hadoop",
			'D' => "ALWAYS False"
		),
		'correct' => 'B',
		'problem' => 2,
		'difficulty' => 1
	);
$mongoDb->getQuestions()->insertOne($insert);

$insert = 
	array(
		'id' => 9,
		'enonce' => "Hive can be used for real time queries.",
		'reponses' => array(
			'A' => "TRUE",
			'B' => "FALSE",
			'C' => "True if data set is small",
			'D' => "True for some distributions"
		),
		'correct' => 'B',
		'problem' => 4,
		'difficulty' => 2
	);
$mongoDb->getQuestions()->insertOne($insert);

$insert = 
	array(
		'id' => 10,
		'enonce' => "Distcp command ALWAYS needs fully qualified hdfs paths.",
		'reponses' => array(
			'A' => "True",
			'B' => "False",
			'C' => "True, if source and destination are in same cluster",
			'D' => "False, if source and destination are in same cluster"
		),
		'correct' => 'A',
		'problem' => 2,
		'difficulty' => 4
	);
$mongoDb->getQuestions()->insertOne($insert);

//------- INSERT CATEGORIES ------- //
$insert = 
	array(
		'id' => 1,
		'nom' => "Big Data",
		'problems' => array(1, 2)
	);
$mongoDb->getCategories()->insertOne($insert);

$insert = 
	array(
		'id' => 2,
		'nom' => "3D",
		'problems' => array(3, 4)
	);
$mongoDb->getCategories()->insertOne($insert);

$insert = 
	array(
		'id' => 3,
		'nom' => "Analyse d'images",
		'problems' => array(1, 4)
	);
$mongoDb->getCategories()->insertOne($insert);

//------- INSERT PROBLEMES ------- //
$insert = 
	array(
		'id' => 1,
		'nom' => "Spark"
	);
$mongoDb->getProblems()->insertOne($insert);

$insert = 
	array(
		'id' => 2,
		'nom' => "Hadoop"
	);
$mongoDb->getProblems()->insertOne($insert);

$insert = 
	array(
		'id' => 3,
		'nom' => "Data Mining"
	);
$mongoDb->getProblems()->insertOne($insert);

$insert = 
	array(
		'id' => 4,
		'nom' => "MongoDb"
	);
$mongoDb->getProblems()->insertOne($insert);


/*
//$mongoDb->getQuestions()->insertOne($insert);
//$results = $mongoDb->getQuestions()->find(array(), array("summary" => true))->toArray();


//------- PRINTS ------- //
$results = $mongoDb->getCategories()->find(array(), array("summary" => true))->toArray();
print_r($results);
echo '<br>';
$results = $mongoDb->getProblems()->find(array(), array("summary" => true))->toArray();
print_r($results);
echo '<br>';
$results = $mongoDb->getQuestions()->find(array(), array("summary" => true))->toArray();
print_r($results);
die();
*/

//------- EXEMPLES ------- //
//$mongoDb->getQuiz()->insertOne($insert);
//$mongoDb->getQuiz()->deleteOne(array('id' => 1));
// echo '<pre>';
// $results = $mongoDb->getScores()->find(array(), array("summary" => true))->toArray();
// print_r($results);
// $mongoDb->getQuestions()->updateOne(array('id'=>3), array('$set'=>array('problem'=>2)));
// $mongoDb->getQuestions()->updateOne(array('id'=>4), array('$set'=>array('problem'=>3)));
// $mongoDb->getQuestions()->updateOne(array('id'=>5), array('$set'=>array('problem'=>4)));
// $results = $mongoDb->getComments()->find(array(), array("summary" => true))->toArray();
// print_r($results);
// die();

// Initialise les variables de session
require(ABSPATH . 'include/session.php');

// Initialise l'API pour l'utilisateur connecté
if(isset($_SESSION['id'])){
	$id = $_SESSION['id'];
}else{
	$id = null;
}
if(isset($_GET['api_key'])){
	$results = $db->getRowsFromQuery("SELECT * FROM `users` WHERE `api_key`='".$_GET['api_key']."'");
	if(!empty($results)){
		$id = $results[0]['id'];
	}
}
$api = new Api($id);

// Charge les fonctions utiles
require(ABSPATH . 'include/functions.php');

// Charge la page demandé par l'utilisateur
if(!isset($ajax)){
	require(ABSPATH . 'include/dispatcher.php');
}

?>