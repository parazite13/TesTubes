<?php 

class MongoDb{

	private $bd;
	private $nomBd;

	private $categories;
	private $questions;
	private $problems;

	function __construct($nom){

		$this->nomBd = $nom;

		$client = new MongoDB\CLient();
		$this->bd = $client->selectDatabase('testubes');

		$this->categories = $this->bd->selectCollection('categories');
		$this->questions = $this->bd->selectCollection('questions');
		$this->problems = $this->bd->selectCollection('problems');
	}

	function getCategories(){
		return $this->categories;
	}

	function getQuestions(){
		return $this->questions;
	}

	function getProblems(){
		return $this->problems;
	}

	
}

?>
