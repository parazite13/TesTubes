<?php 
	$ajax='';
	require '../init.php';

	// if(isset($_GET['id'])){
	// 	$query = $mongoDb->getQuestions()->find(array('id'=>$_GET['id']))->toArray()[0];
	// 	$correct = $query->correct;
	// 	echo $correct;
	// }
	$questions = array_keys($_GET);
	$goodAnswers;
	$query = $mongoDb->getQuestions()->find(array('id'=>array('$in'=>$questions)))->toArray();

	foreach ($query as $question) {
		$goodAnswers[$question->id] = $question->correct;
	}
	echo json_encode($goodAnswers);
?>