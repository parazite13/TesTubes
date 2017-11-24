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
		</div>
	</div>
	<?php getFooter(); ?>

</body>

</html>
