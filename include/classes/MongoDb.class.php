<?php 

class MongoDb{

	private $bd;
	private $nomBd;

	private $quizz;

	function __construct($nom){

		$this->nomBd = $nom;

		$client = new MongoDB\CLient();
		$this->bd = $client->selectDatabase('testubes');
		$this->quizz = $this->bd->selectCollection('quizz');
	}

	function getQuizz(){
		return $this->quizz;
	}

	
}

?>
