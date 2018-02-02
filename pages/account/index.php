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
						WHERE `id_user` = '" . $_SESSION['id']."'";
			$db->executeQuery($query);
		}
		//l'utilisateur a cliqué sur le bouton "enregistrer" dans les préférences auteurs
		if (isset($_POST['changePrefAuthor'])){
			$query = "	UPDATE `preferences_author` 
						SET `titre` = ". (isset($_POST['titre']) ? '1' : '0') ." ,
						`videos` = ". (isset($_POST['videos']) ? '1' : '0') ." ,
						`date` = ". (isset($_POST['date']) ? '1' : '0') ." ,
						`description` = ". (isset($_POST['description']) ? '1' : '0') ." 
						WHERE `id_user` = '" . $_SESSION['id']."'";
			$db->executeQuery($query);
		}
	?>
	<div class="container margin-top">
		<div class="control-group">
			<ul id="tabbed-menu-main" class="nav nav-tabs">
				<li class="nav-item">
					<a href="#" data-content="preferences-user" class="nav-link">
						Préférences Vidéos
					</a>
				</li>
				<li class="nav-item">
					<a href="#" data-content="preferences-author" class="nav-link">
						Préférences Auteurs
					</a>
				</li>
				<li class="nav-item">
					<a href="#" data-content="quiz-user" class="nav-link">
						Quiz
					</a>
				</li>
				<li class="nav-item">
					<a href="#" data-content="api" class="nav-link">
						API
					</a>
				</li>
			</ul>
			<div id="details-content" class="mt-2">
				<section id="preferences-user" class="mx-0 px-0 container placeholders d-none">
					<form method="post" action="">
						<?php
						$array = $api->getPreferences();
						foreach ($array as $key => $value):
							if($key != 'id' && $key != 'id_user'):
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
				<section id="preferences-author" class="mx-0 px-0 container placeholders d-none">
					<form method="post" action="">
						<?php
						$array = $api->getPreferencesAuthor();
						foreach ($array as $key => $value):
							if($key != 'id' && $key != 'id_user'):
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
						<button class="btn btn-success" name="changePrefAuthor" role="button" type="submit">Enregistrer</button>
					</form>
				</section>
				<section id="quiz-user" class="mx-0 px-0 container placeholders d-none">
					<ul id="tabbed-menu-category" class="nav nav-tabs">
					<?php $categories = $api->getCategories()?>
					<?php foreach ($categories as $category) :?>
						<li class="menu-item-category">
							<a href="#" data-content="category<?=$category->id?>" class="nav-link">
								<?=$category->nom?>
							</a>
							<?php $problems = $api->getProblems($category->id)?>
							<ul id="category<?=$category->id?>" class="nav nav-tabs problems d-none">
							<?php foreach ($problems as $problem) :?>
								<li class="nav-item">
									<a href="#" data-content="problem<?=$problem->id?>" class="nav-link problem-item">
										<?=$problem->nom?>
									</a>
								</li>
							<?php endforeach ?>
							</ul>
						</li>
					<?php endforeach ?>
					</ul>
					<?php $problems = $api->getProblems()?>
					<?php foreach ($problems as $problem) :?>
						<form class="quiz d-none" id="problem<?=$problem->id?>" action="" method="post" onsubmit="return checkQuiz()">
							<?php
							$questions = $api->getQuestions(0, $problem->id);
							foreach ($questions as $question) :?>
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
							<button class="btn btn-success" role="button" type="submit">Valider</button>
						</form>
					<?php endforeach ?>
				</section>
				<section id="api" class="mx-0 px-0 container placeholders d-none">
					<label id="activate-api" class="control control-checkbox" style="width:fit-content">
	                    Activer l'API
	                    <input type="checkbox" name="api" value="api" <?php isset($_SESSION['api_key']) ? print 'checked="checked"':print ''?>/>
	                    <div class="control_indicator"></div>
	                </label>
	                Clef : <span id="api-value"><?php isset($_SESSION['api_key']) && $_SESSION['api_key'] != null ? print $_SESSION['api_key'] : print '' ?></span><br>
	                <a href="<?=ABSURL?>api">Accèder à l'API</a>
				</section>
			</div>
		</div>
	</div>
	<?php getFooter(); ?>

	<script type="text/javascript">
		$(document).ready(function(){
			// Menu onglet principal
			$('#tabbed-menu-main a').click(function(){
				$('#tabbed-menu-main a').removeClass('active');
				$(this).addClass('active');
				$('#details-content > section').addClass('d-none');
				$('#' + $(this).attr('data-content')).removeClass('d-none');
			});

			// Menu onglet catégories
			$('.menu-item-category > a').click(function(){
				$('.menu-item-category a').removeClass('active');
				$(this).addClass('active');
				$('.problems').addClass('d-none');
				$('.quiz').addClass('d-none');
				$('#' + $(this).attr('data-content')).removeClass('d-none');
			});

			// Menu onglet problemes
			$('.problem-item').click(function(){
				$('.problem-item').removeClass('active');
				$(this).addClass('active');
				$('.quiz').addClass('d-none');
				$('#' + $(this).attr('data-content')).removeClass('d-none');
			});

			// Activation APIt
			$('#activate-api input').click(function(){
				$.get("ajax/activationApi", {activation: $(this).prop("checked")}, function(data){
					$('#api-value').html(data);
				});
			});
		});

		function checkQuiz(){
			//si l'utilisateur a répondu a toutes les questions
			if($(this).parent().find('input:checked').length == $(this).parent().find('.question').length){
				//demande au serveur les bonnes réponses pour colorier et stock les réponses user
				var url = 'ajax/checkQuiz';
				$.get(url, $('#quiz-user form').serialize(), function(result){
					var res = JSON.parse(result);
					$.each(res, function(idQuestion, correctAnswer){
						//colorie la bonne réponse
						$('[value=' + correctAnswer + '][name=' + idQuestion + ']').parent().css('background-color', '#46E275');
						var inputChecked = $('[name=' + idQuestion + ']input:checked');
						//colorie la réponse choisie en rouge si elle est fausse
						if(inputChecked.attr('value') != correctAnswer){
							inputChecked.parent().css('background-color', '#E97878');
						}
						//bloque les réponses
						//$(this).parent().find('input').prop("disabled", true);
						//$(this).prop("disabled", true);
					});
				});
			}
			return false;
		}
	</script>
</body>

</html>
