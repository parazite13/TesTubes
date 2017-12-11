<!DOCTYPE html>
<html>

<head>
	<?php getHead(); ?>
	<title>TesTubes - Mon compte</title>
</head>

<body>
	
	<?php if(isAdmin()): ?>


		<?php 

			if(isset($_POST['question'])){

				$max = 0;
				$questions = $mongoDb->getQuestions()->find(array(), array("summary" => true))->toArray();
				foreach($questions as $question){
					if($question->id > $max){
						$max = $question->id;
					}
				}

				$response = array();
				$key = "a";
				$i = 1;
				foreach($_POST as $toto => $value){
					if(strpos($toto, "question-reponse-") !== false) continue;
					if(isset($_POST['question-reponse-' . $i])){
						$response[ucfirst($key)] = $_POST['question-reponse-' . $i];
						$key++;
						$i++;
					}
				}

				$key = "a";
				$i = 1;
				while($_POST['correct'] > $i){
					$key++;
					$i++;
				}

				$insert = 
				array(
					'id' => $max + 1,
					'enonce' => $_POST['question-enonce'],
					'reponses' => $response,
					'correct' => ucfirst($key),
					'problem' => intval($_POST['question-problem']),
					'difficulty' => intval($_POST['question-difficulte'])
				);
				$mongoDb->getQuestions()->insertOne($insert);

			}
		?>

		<?php getHeader(); ?>

		<div class="container margin-top">
			
			<ul id="tabbed-menu" class="nav nav-tabs">
				<li class="nav-item">
					<a href="#" data-content="question-section" class="nav-link">
						Ajouter une question
					</a>
				</li>
				<li class="nav-item">
					<a href="#" data-content="quizz-section" class="nav-link">
						Ajouter un quizz
					</a>
				</li>
			</ul>

			<div id="details-content">
				

				<section id="question-section" class="d-none mx-0 px-0 container text-center placeholders">

					<form action="" method="post">

						<div class="form-group">
							<label for="question-enonce">Enoncé de la question</label>
							<textarea class="form-control" name="question-enonce" id="question-enonce" rows="3"></textarea>
						</div>

						<div id="group-reponses" class="form-group">
							<label for="question-reponse">Réponses</label>
							<br>
							<button type="button" onclick="addAnswer()">Ajouter une réponse</button>
							<br>
							Réponse 1
							<input type="radio" name="correct" value="1"/>
							<input class="form-control" type="text" id="question-reponse-1" name="question-reponse-1"/>
							<br>
						</div>

						<div class="form-group">
							Difficultée
							<br>
							<input id="question-difficulte" name="question-difficulte" class="form-control" type="number" min="1" max="5">
						</div>

						<div class="form-group">
							Problème
							<br>
							<select class="form-control" id="question-problem" name="question-problem">
								<?php foreach($api->getProblems() as $problem): ?>
									<option value="<?= $problem->id ?>">
										<?= $problem->nom ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>

						<button name="question" type="submit" class="btn btn-primary">Ajouter</button>

					</form>

				</section>

				<section id="quizz-section" class="d-none mx-0 px-0 container text-center placeholders">
				</section>		
			</div>
		</div>

		<?php getFooter(); ?>

	<?php else: ?>

		Vous n'avez pas les autorisations pour accéder à cette page !

	<?php endif; ?>

</body>

<script type="text/javascript">

$(document).ready(function(){

	// Menu onglet
	$('#tabbed-menu a').click(function(){
		$('#tabbed-menu a').removeClass('active');
		$(this).addClass('active');
		$('#details-content > section').addClass('d-none');
		$('#' + $(this).attr('data-content')).removeClass('d-none');
	});


});

function addAnswer(){

	var nbReponses = $('#group-reponses input[type="text"]').length;

	var html = 'Réponse '+ (nbReponses + 1) +' <input type="radio" name="correct" value="'+ (nbReponses + 1) +'"/><input type="text" class="form-control" name="question-reponse-' + (nbReponses + 1) + '" id="question-reponse-' + (nbReponses + 1) + '"/><br>';
	$('#group-reponses').append(html);

}

</script>

</html>
