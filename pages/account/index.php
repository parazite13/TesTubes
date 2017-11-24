<!DOCTYPE html>
<html>

<head>
	<?php getHead(); ?>
	<title>TesTubes - Mon compte</title>
</head>

<body>
	
	<?php 
		getHeader(); 
	?>
	<div class="container margin-top">
		<div class="control-group">
			<?php
			$query = "SELECT * FROM `preferences` WHERE `pseudo`='". $_SESSION['pseudo'] ."'";
			$array = $db->getRowFromQuery($query, false);
			foreach ($array as $key => $value):
				if($key != 'id' && $key != 'pseudo'):
			?>
				<label class="control control-checkbox">
					<?= ucfirst($key) ?>
				    <input type="checkbox" <?php $value ? print 'checked="unchecked"':print ''?> />
				    <div class="control_indicator"></div>
				</label>
			<?php 
				endif;
			endforeach;
			?>
		</div>
	</div>
	<?php getFooter(); ?>

</body>

</html>
