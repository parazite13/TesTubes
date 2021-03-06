<!DOCTYPE html>
<html>

<head>
	<?php getHead(); ?>
	<title>TesTubes - Accueil</title>
</head>

<body>
	
	<?php 
		getHeader();
		if(isset($_SESSION['alertPwd'])){
			echoAlert('danger', 'Nom d\'utilisateur ou mot de passe incorrect(s)');
			unset($_SESSION['alertPwd']);
		}
		//visiteur -> toutes les préférences à 1
		if(!isConnected()){
			$myPref = array('titre' => 1,
							'auteur' => 1,
							'vues' => 1,
							'date' => 1,
							'description' => 1,
							'duree' => 1
						);
			$myPrefAuthor = array('titre' => 1,
							'videos' => 1,
							'date' => 1,
							'description' => 1
						);
		}
		//utilisateur connecté -> va chercher ses préférences dans la bdd
		else{
			$myPref = $api->getPreferences();
			$myPrefAuthor = $api->getPreferencesAuthor();
		}
	?>

	<div class="container-fluid">
		<div class="row">
			<nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar fixed-top margin-top">
				<ul id="search-items" class="nav nav-pills flex-column">
					<?php $categories = $mongoDb->getCategories()->find(array(), array("summary" => true))->toArray();?> 
					<?php foreach ($categories as $category) :?>
							<li class="nav-item">
								<a class="nav-link" search="<?=strtolower($category->nom)?>" href="#"><?=$category->nom?></a>
							</li>
					<?php endforeach ?>
				</ul>
			</nav>

			<main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3 margin-top">

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
						<a href="#" data-content="search-results-map" class="nav-link" onclick="initMap()">
							Carte
						</a>
					</li>
				</ul>
	
				<div class="header-results">
					<h1 id="search-results-title"></h1>
				</div>

				<div id="details-content">

					<nav class="my-2">
						<ul class="pagination mx-auto d-none">
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
            						<input class="form-check-input" type="checkbox" <?php $myPref["titre"] ? print "checked": print ""?> filter="videoTitle"> Titre
          						</label>
          						<label class="form-check-label mx-1">
            						<input class="form-check-input" type="checkbox" <?php $myPref["auteur"] ? print "checked": print ""?> filter="videoAuthor"> Auteur
          						</label>
          						<label class="form-check-label mx-1">
            						<input class="form-check-input" type="checkbox" <?php $myPref["vues"] ? print "checked": print ""?> filter="videoViews"> Vues
          						</label>
          						<label class="form-check-label mx-1">
            						<input class="form-check-input" type="checkbox" <?php $myPref["date"] ? print "checked": print ""?> filter="videoDate"> Date
          						</label>
          						<label class="form-check-label mx-1">
            						<input class="form-check-input" type="checkbox" <?php $myPref["description"] ? print "checked": print ""?> filter="videoDescr"> Description
          						</label>
          						<label class="form-check-label mx-1">
            						<input class="form-check-input" type="checkbox" <?php $myPref["duree"] ? print "checked": print ""?> filter="videoDuration"> Durée
          						</label>
        					</div>
     					</div>
     					<div id="search-results-videos-div"></div>
					</section>
						
					<section id="search-results-authors" class="mx-0 px-0 container text-center placeholders d-none">
						<div class="form-group row ml-1">
							<div class="form-check">
        						<label class="form-check-label mx-1">
            						<input class="form-check-input" type="checkbox" <?php $myPrefAuthor["titre"] ? print "checked": print ""?> filter="channelTitle"> Titre
          						</label>
          						<label class="form-check-label mx-1">
            						<input class="form-check-input" type="checkbox" <?php $myPrefAuthor["videos"] ? print "checked": print ""?> filter="channelVideos"> Nombre de vidéos
          						</label>
          						<label class="form-check-label mx-1">
            						<input class="form-check-input" type="checkbox" <?php $myPrefAuthor["date"] ? print "checked": print ""?> filter="channelDate"> Date de création
          						</label>
          						<label class="form-check-label mx-1">
            						<input class="form-check-input" type="checkbox" <?php $myPrefAuthor["description"] ? print "checked": print ""?> filter="channelDescr"> Description
          						</label>
        					</div>
        				</div>
        				<div id="search-results-author-div"></div>
					</section>

					<section id="search-results-map" class="mx-0 px-0 container text-center placeholders d-none">

						<form id="form-map" class="form-inline my-1" onSubmit="return false;">
							<label class="sr-only" for="center-location">Zone de recherche</label>
							<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="center-location" placeholder="Ex: Marseille">

							<label class="sr-only" for="radius">Km</label>
							<div class="input-group mb-2 mr-sm-2 mb-sm-0">
								<input type="number" min="1" max="1000" class="form-control" id="radius" placeholder="Rayon">
								<div class="input-group-addon">Km</div>
							</div>

							<button id="submit-map" type="submit" role="button" class="btn btn-primary">
								<i class="fa fa-spinner fa-spin d-none"></i>
								Rechercher
							</button>
						</form> 

						<div id="map"></div>
					</section>

					<nav>
						<ul class="pagination mx-auto d-none">
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
				</div>
			</main>
		</div>
	</div>
	

	<?php 
		echo '<script>';
			include ABSPATH."js/script.js.php";
		echo '</script>';
		getFooter(); 

		if(isset($_GET['q'])){
			echo '
			<script>
				$(document).ready(function(){
					searchTerm = $("#query").val();
					displayVideos(searchTerm);
					getAuthors(searchTerm);
				});
			</script>
			';
		}
	?>

</body>

</html>
