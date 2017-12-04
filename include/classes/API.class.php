<?php 

class API{

	private $userId;

	private $db;

	function __construct($userId = null){
		$this->userId = $userId;

		global $db;
		$this->db = $db;
	}

	/**
	 * Retourne un tableau contenant les informations de l'utilisateur courant
	 */
	function getUserInfo() : array{
		$this->checkUserId();

		return $this->db->getRowFromQuery("SELECT * FROM `users` WHERE `id`=".$this->userId, false);	
	}

	private function checkUserId(){
		if(is_null($this->userId)) throw new Exception("API request need userId");
	}
	
}

?>
