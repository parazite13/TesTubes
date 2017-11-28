<?php 

class MongoDb{

	private $bd;
	private $nomBd;

	private $quiz;
	private $questions;

	function __construct($nom){

		$this->nomBd = $nom;

		$client = new MongoDB\CLient();
		$this->bd = $client->selectDatabase('testubes');

		$this->quiz = $this->bd->selectCollection('quiz');
		$this->questions = $this->bd->selectCollection('questions');
	}

	function getQuiz(){
		return $this->quiz;
	}

	function getQuestions(){
		return $this->questions;
	}

	
}

?>
