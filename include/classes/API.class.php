<?php 

class API{

	private $userId;

	private $db;
	private $mongoDb;

	function __construct($userId = null){
		$this->userId = $userId;

		global $db, $mongoDb;
		$this->db = $db;
		$this->mongoDb = $mongoDb;
	}

	/**
	 * Retourne un tableau contenant les informations de l'utilisateur courant
	 */
	function getUserInfos() : array{
		$this->checkUserId();

		return $this->db->getRowFromQuery("SELECT * FROM `users` WHERE `id`=".$this->userId, false);	
	}

	/**
	 * Retourne un tableau contenant l'information quant à l'affichage ou non des préférences
	 * de l'utilisateur
	 */
	function getPreferences() : array{
		$this->checkUserId();

		return $this->db->getRowFromQuery("SELECT * FROM `preferences` WHERE `id_user` = '" . $this->userId . "'", false);
	}

	/**
	 * Retourne un tableau contenant l'information quant à l'affichage ou non des préférences
	 * de l'utilisateur concernant les auteurs
	 */
	function getPreferencesAuthor() : array{
		$this->checkUserId();

		return $this->db->getRowFromQuery("SELECT * FROM `preferences_author` WHERE `id_user` = '" . $this->userId . "'", false);
	}

	/**
	 * Renvoie l'ensemble des catégories présentes en base de données
	 */
	function getCategories() : array{
		return $this->mongoDb->getCategories()->find(array(), array("summary" => true))->toArray();
	}

	/**
	 * Renvoie un tableau contenant les commentaires d'une video
	 * @param  string $video id de la video pour laquelle les commentaires doivent etre affichés
	 * null indique que tous les commentaires de toutes les videos doivent être récupérés
	 */
	function getComments(string $video = null) : array{

		$array = array();
		if($video == null){
			$array = $this->mongoDb->getComments()->find(array(), array("summary" => true))->toArray();
		}else{
			$array = $this->mongoDb->getComments()->find(array('id_video'=>$video))->toArray();
		}

		uasort($array, function($a, $b){
			return $a->time_video < $b->time_video;
		});


		return $array;
	}

	/**
	 * Renvoie un tableau contenant les ids des problemes
	 * @param  integer $category id de la catégorie pour laquelle les problemes doivent etre affichés
	 * 0 indique que tous les problèmes de toutes les catégories doivent être récupérés
	 */
	function getProblems(int $category = 0) : array{
		if($category == 0){
			return $this->mongoDb->getProblems()->find(array(), array("summary" => true))->toArray();
		}else{
			$problemsId = $this->mongoDb->getCategories()->find(array("id"=>intval($category)))->toArray()[0]->problems;
			return $this->mongoDb->getProblems()->find(array('id'=>array('$in'=>$problemsId)))->toArray();
		}
	}

	/**
	 * Renvoie un tableau contenant les questions selon certains filtres
	 * @param  integer $category id de la catégorie pour laquelle les questions doivent etre affichés
	 * 0 indique que toute les questions de toutes les catégories doivent être récupérées
	 * @param  integer $problem id du probleme pour laquelle les questions doivent etre affichés
	 * 0 indique que toute les questions de tous les problemes doivent être récupérées
	 */
	function getQuestions(int $category = 0, int $problem = 0) : array{
		if($category == 0 && $problem == 0){
			return $this->mongoDb->getQuestions()->find(array(), array("summary" => true))->toArray();
		}else{
			if($category != 0){
				if($problem == 0){
					$problemsId = $this->mongoDb->getCategories()->find(array(), array("summary" => true))->toArray()[0]->problems;
					return $this->mongoDb->getQuestions()->find(array('problem'=>array('$in'=>$problemsId)))->toArray();
				}else{
					return $this->mongoDb->getQuestions()->find(array('problem'=>array('$in'=>intval($problem))))->toArray();
				}
			}else{
				return $this->mongoDb->getQuestions()->find(array('problem'=>intval($problem)))->toArray();
			}
		}
	}

	private function checkUserId(){
		if(is_null($this->userId)) throw new Exception("API request need userId");
	}
	
}

?>
