<nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse d-inline-block">

	<a class="navbar-brand" href="<?=ABSURL?>">TesTubes</a>

	<form id="search-term" class="d-inline-block form-inline mt-2 mt-md-0">
		<input id="query" class="form-control mr-sm-2" type="text" placeholder="Rechercher">
		<button role="button" class="btn btn-outline-secondary my-2 my-sm-0" type="submit">
			<i class="fa fa-search" aria-hidden="true"></i>
		</button>
	</form>
	<div id="connection-items" class="d-inline-block my-1">
		<?php if(!isConnected()): ?>
			<button for="inscription" role="button" class="btn btn-success my-2 my-sm-0 btn-user">Inscription</button>
			<button for="connexion" role="button" class="btn btn-info mr-2 my-2 my-sm-0 btn-user">Connexion</button>
		<?php else: ?>
			<form action="" method="post" class="d-inline-block">
				<button name="disconnect" type="submit" role="button" class="btn btn-outline-info my-2 my-sm-0">Se déconnecter</button>
			</form>
			<h5 class="d-inline mr-3 my-1" id="pseudo-display"><i><?= $_SESSION['pseudo']?></i></h5>
			<a href="<?=ABSURL?>account">
				<i class="fa fa-user mr-3" style="vertical-align: middle;" aria-hidden="true"></i>
			</a>
		<?php endif ?>
	</div>
</nav>