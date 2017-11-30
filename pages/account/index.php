<!DOCTYPE html>
<html>

<head>
	<?php getHead(); ?>
	<title>TesTubes - Mon compte</title>
</head>

<body>
	
	<?php 
		getHeader(); 

		//l'utilisateur a cliqué sur le bouton "enregistrer"
		if (isset($_POST['changePref'])){
			$query = "	UPDATE `preferences` 
						SET `titre` = ". (isset($_POST['titre']) ? '1' : '0') ." ,
						`auteur` = ". (isset($_POST['auteur']) ? '1' : '0') ." ,
						`vues` = ". (isset($_POST['vues']) ? '1' : '0') ." ,
						`date` = ". (isset($_POST['date']) ? '1' : '0') ." ,
						`description` = ". (isset($_POST['description']) ? '1' : '0') ." ,
						`duree` = ". (isset($_POST['duree']) ? '1' : '0') ." 
						WHERE `pseudo` = '" . $_SESSION['pseudo']."'";
			$db->executeQuery($query);
		}
	?>
	<div class="container margin-top">
		<div class="control-group">
			<ul id="tabbed-menu" class="nav nav-tabs">
				<li class="nav-item">
					<a href="#" data-content="preferences-user" class="nav-link active">
						Préférences
					</a>
				</li>
				<li class="nav-item">
					<a href="#" data-content="quiz-user" class="nav-link">
						Quiz
					</a>
				</li>
			</ul>
			<div id="details-content" class="mt-2">
				<section id="preferences-user" class="mx-0 px-0 container placeholders">
					<form method="post" action="">
						<?php
						$query = "SELECT * FROM `preferences` WHERE `pseudo`='". $_SESSION['pseudo'] ."'";
						$array = $db->getRowFromQuery($query, false);
						foreach ($array as $key => $value):
							if($key != 'id' && $key != 'pseudo'):
						?>
								<label class="control control-checkbox">
									<?= ucfirst($key) ?>
									<input type="checkbox" <?php echo 'name="'.$key.'"' ?> <?php $value ? print 'checked="unchecked"':print ''?> />
									<div class="control_indicator"></div>
								</label>
						<?php 
							endif;
						endforeach;
						?>
						<button class="btn btn-success" name="changePref" role="button" type="submit">Enregistrer</button>
					</form>
				</section>
				<section id="quiz-user" class="mx-0 px-0 container placeholders d-none">
					<form action="" method="post" onsubmit="return checkQuiz()">
						<?php 
						$quiz = $mongoDb->getQuestions()->find(array(), array("summary" => true))->toArray();
						foreach ($quiz as $question) :?>
							<div class="question">
								<?=$question->enonce?>
								<ul>
									<?php foreach ($question->reponses as $key => $value):?>
										<label class="control control-checkbox" style="width:fit-content">
											<?=$value?>
											<input type="radio" name="<?=$question->id?>" value="<?=$key?>" />
											<div class="control_indicator"></div>
										</label>
									<?php endforeach?>
								</ul>
								<hr>
							</div>
						<?php endforeach?>
						<button class="btn btn-success" role="button" type="submit">Envoyer</button>
					</form>
				</section>
			</div>
		</div>
	</div>
	<?php getFooter(); ?>

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

		function checkQuiz(){
			//si l'utilisateur a répondu a toutes les questions
			if($('#quiz-user input:checked').length == $('.question').length){
				var url = 'ajax/checkQuiz';
				$.get(url, $('#quiz-user form').serialize(), function(result){
					var res = JSON.parse(result);
					$.each(res, function(id, correctAnswer){
						//colorie la bonne réponse
						$('[value=' + correctAnswer + '][name=' + id + ']').parent().css('background-color', '#46E275');
						var inputChecked = $('[name=' + id + ']input:checked');
						//colorie la réponse choisie en rouge si elle est fausse
						if(inputChecked.attr('value') != correctAnswer){
							inputChecked.parent().css('background-color', '#E97878');	
						}
						//bloque les réponses
						$('#quiz-user input').prop("disabled", true);
					});
				});
			}
			return false;
		}
	</script>
</body>

</html>
