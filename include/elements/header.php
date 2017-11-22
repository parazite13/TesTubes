<nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse d-inline-block">

	<a class="navbar-brand" href="#">TesTubes</a>

	<form id="search-term" class="d-inline-block form-inline mt-2 mt-md-0">
		<input id="query" class="form-control mr-sm-2" type="text" placeholder="Rechercher">
		<button role="button" class="btn btn-outline-secondary my-2 my-sm-0" type="submit">
			<i class="fa fa-search" aria-hidden="true"></i>
		</button>
	</form>
	<?php if(!isConnected()): ?>
		<button for="inscription" role="button" class="btn btn-success my-2 my-sm-0 btn-user">Inscription</button>
		<button for="connexion" role="button" class="btn btn-info my-2 my-sm-0 btn-user">Connexion</button>
	<?php else: ?>
		<h5 class="d-inline mr-3" id="pseudo-display">Bonjour, <i><?= $_SESSION['pseudo']?></i></h5>
		<form action="" method="post">
			<button  name="disconnect" type="submit" role="button" class="btn btn-outline-info my-2 my-sm-0">Se déconnecter</button>
		</form>
	<?php endif ?>
</nav>