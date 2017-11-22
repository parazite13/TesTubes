<!DOCTYPE html>
<html>

<head>
	<?php getHead(); ?>
	<title></title>
</head>

<body>
	
	<?php getHeader(); ?>

	
	<div class="container-fluid">
		<div class="row">
			<nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar fixed-top" style="margin-top: 95px;">
				<ul id="search-items" class="nav nav-pills flex-column">
					<li class="nav-item">
						<a class="nav-link" search="big data" href="#">Big Data</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" search="3D" href="#">3D</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" search="analyse d'image" href="#">Analyse d'image</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" search="musique" href="#">Musique</a>
					</li>
				</ul>
			</nav>

			<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3" style="margin-top: 95px;">

				<ul id="tabbed-menu" class="nav nav-tabs">
					<li class="nav-item">
						<a href="#" data-content="search-results-videos" class="nav-link active">
							Vidéos
						</a>
					</li>
					<li class="nav-item">
						<a href="#" data-content="search-results-authors" class="nav-link">
							Auteurs
						</a>
					</li>
					<li class="nav-item">
						<a href="#" data-content="search-results-map" class="nav-link">
							Carte
						</a>
					</li>
				</ul>
	
				<div class="header-results">
					<h1 id="search-results-title" style="position: absolute;"></h1>
				</div>

				<div id="details-content">

					<nav class="my-2">
						<ul class="pagination mx-auto d-none" style="width: fit-content">
							<li class="page-item">
								<a token="" class="page-link page-previous d-none" href="#" aria-label="Previous">
									<span aria-hidden="true">&laquo;</span>
									<span class="sr-only">Previous</span>
								</a>
							</li>
							<li class="page-item">
								<a class="page-link current-page" href="#">1</a>
							</li>
							<li>
								<a token="" class="page-link page-next" href="#" aria-label="Next">
									<span aria-hidden="true">&raquo;</span>
									<span class="sr-only">Next</span>
								</a>
							</li>
						</ul>
					</nav>

					<section id="search-results-videos" class="mx-0 px-0 container text-center placeholders">
						<div class="form-group row ml-1">
							<div class="form-check">
        						<label class="form-check-label mx-1">
            						<input class="form-check-input" type="checkbox" checked filter="videoTitle"> Titre
          						</label>
          						<label class="form-check-label mx-1">
            						<input class="form-check-input" type="checkbox" checked filter="videoAuthor"> Auteur
          						</label>
          						<label class="form-check-label mx-1">
            						<input class="form-check-input" type="checkbox" checked filter="videoViews"> Vues
          						</label>
          						<label class="form-check-label mx-1">
            						<input class="form-check-input" type="checkbox" checked filter="videoDate"> Date
          						</label>
          						<label class="form-check-label mx-1">
            						<input class="form-check-input" type="checkbox" checked filter="videoDescr"> Description
          						</label>
          						<label class="form-check-label mx-1">
            						<input class="form-check-input" type="checkbox" checked filter="videoDuration"> Durée
          						</label>
        					</div>
     					</div>
     					<div id="search-results-videos-div"></div>
					</section>

					<section id="search-results-authors" class="mx-0 px-0 container text-center placeholders d-none"></section>

					<section id="search-results-map" class="mx-0 px-0 container text-center placeholders d-none">

						<form id="form-map" class="form-inline my-1" onSubmit="return false;">
							<label class="sr-only" for="center-location">Zone de recherche</label>
							<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="center-location" placeholder="Ex: Marseille">

							<label class="sr-only" for="radius">Km</label>
							<div class="input-group mb-2 mr-sm-2 mb-sm-0">
								<input type="number" max="1000" class="form-control" id="radius">
								<div class="input-group-addon">Km</div>
							</div>

							<button id="submit-map" type="submit" role="button" class="btn btn-primary">Rechercher</button>
						</form> 

						<div id="map" style="height: 70vh;"></div>
					</section>

					<nav>
						<ul class="pagination mx-auto d-none" style="width: fit-content">
							<li class="page-item">
								<a token="" class="page-link page-previous d-none" href="#" aria-label="Previous">
									<span aria-hidden="true">&laquo;</span>
									<span class="sr-only">Previous</span>
								</a>
							</li>
							<li class="page-item">
								<a class="page-link current-page" href="#" style="cursor: default;">1</a>
							</li>
							<li>
								<a token="" class="page-link page-next" href="#" aria-label="Next">
									<span aria-hidden="true">&raquo;</span>
									<span class="sr-only">Next</span>
								</a>
							</li>
						</ul>
					</nav>
				</div>
			</main>
		</div>
	</div>
	

	<?php getFooter(); ?>


	<script type="text/javascript" src="<?= ABSURL ?>js/script.js"></script>

</body>

</html>
