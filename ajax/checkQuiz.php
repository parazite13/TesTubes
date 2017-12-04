<?php 
	$ajax='';
	require '../init.php';

	$questions = array_keys($_GET);
	$goodAnswers;
	$query = $mongoDb->getQuestions()->find(array('id'=>array('$in'=>$questions)))->toArray();

	foreach ($query as $question) {
		$goodAnswers[$question->id] = $question->correct;
	}
	echo json_encode($goodAnswers);
?>