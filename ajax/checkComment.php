<?php

$ajax='';
require '../init.php';

$date = date("Y-m-d H:i:s");
$insert = 
	array(
		'date' => $date,
		'time_video' => intval($_GET['chrono']),
		'id_user' => intval($_SESSION['id']),
		'id_video' => $_GET['id_video'],
		'comment' => $_GET['comment']
	);	

$mongoDb->getComments()->insertOne($insert);

echo '<div class="main-com card mt-2" time="' . intval($_GET['chrono']) . '">
									<div class="card-header">
										<div class="col-12 header-com">
											Écrit par <b>'.(isset($_SESSION["pseudo"])?$_SESSION["pseudo"]:"").'</b> (' .$date. ')
										</div>
									</div>
									<div class="card-block">
										<div class="col-12 com">
											' .$_GET['comment']. '
										</div>
									</div>
								</div>'

?>