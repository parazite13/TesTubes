<?php 
	$ajax='';
	require '../init.php';

	$questions = array_keys($_GET);
	$goodAnswers;
	$query = $mongoDb->getQuestions()->find(array('id'=>array('$in'=>$questions)))->toArray();
	$arrayResponses;
	foreach ($query as $question) {
		$goodAnswers[$question->id] = $question->correct;
		if($question->correct == $_GET[$question->id]){
			$arrayResponses[$question->id] = 1;
		}else{
			$arrayResponses[$question->id] = 0;
		}
	}

	$insert = 
		array(
			'date' => date("Y-m-d H:i:s"),
			'id_user' => $_SESSION['id'],
			'responses' => $arrayResponses
		);	

	$mongoDb->getScores()->insertOne($insert);
	
	echo json_encode($goodAnswers);
?>