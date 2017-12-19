<nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse d-inline-block">

	<a class="navbar-brand" href="<?=ABSURL?>">TesTubes</a>

	<form id="search-term" class="d-inline-block form-inline mt-2 mt-md-0">
		<?php if(isHomePage()): ?>
			<input id="query" class="form-control mr-sm-2" type="text" placeholder="Rechercher">
			<button role="button" class="btn btn-outline-secondary my-2 my-sm-0" type="submit">
				<i class="fa fa-search" aria-hidden="true"></i>
			</button>
		<?php endif; ?>
	</form>
	<div id="connection-items" class="d-inline-block my-1">
		<?php if(!isConnected()): ?>
			<button for="inscription" role="button" class="btn btn-success my-2 my-sm-0 btn-user">Inscription</button>
			<button for="connexion" role="button" class="btn btn-info mr-2 my-2 my-sm-0 btn-user">Connexion</button>
		<?php elseif(isAdmin()): ?>
			<form action="" method="post" class="d-inline-block">
				<button name="disconnect" type="submit" role="button" class="btn btn-outline-info my-2 my-sm-0">Se déconnecter</button>
			</form>
			<h5 class="d-inline mr-3 my-1" id="pseudo-display"><i><?= $_SESSION['pseudo']?></i></h5>
			<a href="<?=ABSURL?>admin">
				<i class="fa fa-user mr-3" style="vertical-align: middle;" aria-hidden="true"></i>
			</a>
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
<div class="overlay"></div>
<div class="d-none" id="blur" onclick="$('.overlay').addClass('d-none'); $(this).addClass('d-none');" style="position:fixed; z-index:1100; height:100vh; width:100vw; background-color:rgba(0, 0, 0, 0.5)"></div>