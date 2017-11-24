var searchTerm;
var map;
var markerCoord;

$(document).ready(function () {

	// Bouton de recherche
	$('#search-term').submit(function (event) {
		event.preventDefault();
		searchTerm = $('#query').val();
		displayVideos(searchTerm);
		getAuthors(searchTerm);
	});

	// Items de recherche
	$("#search-items a").click(function(event){
		searchTerm = $(this).attr('search');
		$('#query').val($(this).html());
		displayVideos(searchTerm);
		getAuthors(searchTerm);
	});

	// Menu onglet
	$('#tabbed-menu a').click(function(){
		$('#tabbed-menu a').removeClass('active');
		$(this).addClass('active');
		$('#details-content > section').addClass('d-none');
		$('#' + $(this).attr('data-content')).removeClass('d-none');

		// Enleve la pagination pour la map
		if($(this).html().trim() == "Carte"){
			$('.pagination').addClass('d-none');
		}else{
			$('.pagination').removeClass('d-none');
		}
	});

	// Pagination
	$('.page-next').click(function(event){
		var currentPage = $('.current-page');
		currentPage.html(parseInt(currentPage.html()) + 1);
		if(parseInt(currentPage.html()) <= 1){
			$('.page-previous').addClass('d-none');
		}else{
			$('.page-previous').removeClass('d-none')
		}
		displayVideos(searchTerm, $(this).attr('token'));
		getAuthors(searchTerm, $(this).attr('token'));
	});
	$('.page-previous').click(function(event){
		var currentPage = $('.current-page');
		currentPage.html(parseInt(currentPage.html()) - 1);
		if(parseInt(currentPage.html()) <= 1){
			$(this).addClass('d-none');
		}else{
			$(this).removeClass('d-none')
		}
		displayVideos(searchTerm, $(this).attr('token'));
		getAuthors(searchTerm, $(this).attr('token'));
	});

	// Checkbox filtre
	$('.form-check input').click(function(){
		var elem = $('.' + $(this).attr('filter'));
		if($(this).prop('checked')){
			elem.removeClass('d-none');
		}else{
			elem.addClass('d-none');
		}
	});

	// Affichage de la carte
	$('#submit-map').click(function(){

		var spinner = $(this).find('.fa-spin');
		spinner.removeClass('d-none');

		var geocoder = new google.maps.Geocoder();
		geocoder.geocode( {address: $('#center-location').val()}, function(results, status){
			if(status == google.maps.GeocoderStatus.OK){
				markerCoord = {lat: results[0].geometry.location.lat(), lng: results[0].geometry.location.lng()};
				displayMap(markerCoord, $('#radius').val() + "km");
				spinner.addClass('d-none');
			}
		});
	});

	//Boutons connexion et inscription
	$('.btn-user').click(function(){
		var html = "";
		$('#blur').removeClass('d-none');
		if($(this).attr('for') == 'inscription'){
			html += '<div id="inscription" class="card p-3" style="position: absolute; z-index:1200; top:10vh; left: 40vw; right: 40vw; width: 20vw;">\
						<form action="" method="post" onSubmit="return checkInscription();">\
							<label for="username" class="lead">Nom d\'utilisateur :</label>\
							<input autofocus class="form-control mx-auto" type="text" id="username-inscr" name="username-inscr" style="width: 100%;"/>\
							<label for="pwd" class="lead">Mot de passe :</label>\
							<input class="form-control mx-auto" type="password" id="pwd-inscr" name="pwd-inscr" style="width: 100%;"/>\
							<label for="pwd-bis" class="lead">Confirmer mot de passe :</label>\
							<input class="form-control mx-auto" type="password" id="pwd-bis-inscr" name="pwd-bis-inscr" style="width: 100%;"/>\
							<button type="submit" role="button" class="mt-2 btn btn-primary">S\'inscrire</button>\
						</form>\
					</div>';
		}else if($(this).attr('for') == 'connexion'){
			html += '<div id="connexion" class="card p-3" style="position: absolute; z-index:1200; top:10vh; left: 40vw; right: 40vw; width: 20vw;">\
						<form action="" method="post" onSubmit="return checkConnexion();">\
							<label for="username" class="lead">Nom d\'utilisateur :</label>\
							<input autofocus class="form-control mx-auto" type="text" id="username-con" name="username-con" style="width: 100%;"/>\
							<label for="pwd" class="lead">Mot de passe :</label>\
							<input class="form-control mx-auto" type="password" id="pwd-con" name="pwd-con" style="width: 100%;"/>\
							<button type="submit" role="button" class="mt-2 btn btn-primary">Se connecter</button>\
						</form>\
					</div>';
		}
		$('.overlay').removeClass('d-none');
		$('.overlay').html(html);
	});
});

function initMap(){

		markerCoord = {lat: 43, lng: 5};
	    map = new google.maps.Map(document.getElementById('map'), {
	    	zoom: 6,
	    	center: markerCoord
	    });
		
	}

function displayMap(coords, radius){

	var url = 'https://www.googleapis.com/youtube/v3/search';
	var params = {
        part: 'snippet',
        maxResults: '50',
        location: coords.lat + "," + coords.lng,
        locationRadius: radius,
		key: 'AIzaSyCKqVcvBxViYhySoAa0ArgkjN0X1bucHmw',
        type: 'video',
		q: searchTerm
	};

	$.ajax({
		dataType: "json",
		url: url,
		data: params,
		async: false, 
		success: function(data) {

	    	var url = 'https://www.googleapis.com/youtube/v3/videos';
	    	var params = {
	    		id: "",
		        part: 'id,snippet,recordingDetails',
		        key: 'AIzaSyCKqVcvBxViYhySoAa0ArgkjN0X1bucHmw'
	    	}

	    	$(data.items).each(function(index, value){

	    		params.id = value.id.videoId;

	    		$.getJSON(url, params, function (result) {
					var markerCoord = {lat: result.items[0].recordingDetails.location.latitude, lng: result.items[0].recordingDetails.location.longitude};

					var infoWindow = new google.maps.InfoWindow({
        				content: '<a target="_blank" href="https://www.youtube.com/watch?v=' + result.items[0].id + '">'+result.items[0].snippet.title+'</a>'
        			});

					var marker = new google.maps.Marker({
			        	position: markerCoord,
			        	map: map
			        });

			        marker.addListener('click', function() {
          				infoWindow.open(map, marker);
        			});

				});

	    	});
		}
	});
}

function checkConnexion(){
	var rgx = /^([a-zA-Z]|\d)+$/;
	var pseudo = $('#username-con').val();
	var pwd = $('#pwd-con').val();

	return pseudo.length > 3 && pwd.length > 5 && rgx.test(pseudo) && rgx.test(pwd);

}

function checkInscription(){
	var rgx = /^([a-zA-Z]|\d)+$/;
	var pseudo = $('#username-inscr').val();
	var pwd1 = $('#pwd-inscr').val();
	var pwd2 = $('#pwd-bis-inscr').val();

	return pseudo.length > 3 && pwd1.length > 5 && pwd1 == pwd2 && rgx.test(pseudo) && rgx.test(pwd1);
}

function displayVideos(searchTerm, pageToken = undefined) {

	// Affiche la pagination
	$('.pagination').removeClass('d-none');

	var url = 'https://www.googleapis.com/youtube/v3/search';
	var params = {
		maxResults: '10',
		part: 'snippet',
		key: 'AIzaSyCKqVcvBxViYhySoAa0ArgkjN0X1bucHmw',
		type: 'video',
		pageToken: pageToken,
		q: searchTerm
	};

	$.getJSON(url, params, function (searchInfo) {
		displayResults(searchInfo);
		displayVideoInfos();
	});
}

function getAuthors(searchTerm, pageToken = undefined) {

	// Affiche la pagination
	$('.pagination').removeClass('d-none');

	var url = 'https://www.googleapis.com/youtube/v3/search';
	var params = {
		maxResults: '10',
		part: 'snippet',
		key: 'AIzaSyCKqVcvBxViYhySoAa0ArgkjN0X1bucHmw',
		type: 'channel',
		pageToken: pageToken,
		q: searchTerm
	};

	$.getJSON(url, params, function (searchInfo) {
		displayAuthors(searchInfo);
		displayChannelInfos();
	});
}

function displayAuthors(results){
	
	var html = "";
	var entries = results.items;

	$.each(entries, function (index, value) {

		var channel = value.snippet.channelTitle;
		var channelId = value.snippet.channelId;
		var thumbnail = value.snippet.thumbnails.medium.url;

		html += '<div id="channel-' + channelId + '" channel="' + channelId + '" class="row p-2">\
			<div class="col-1 py-2 px-0">\
				<a href="https://www.youtube.com/watch?v=' + channelId + '">\
		 			<img src="' + thumbnail + '" style="width:100%;height:auto">\
				</a>\
			</div>\
			<div class="col-9">\
				<p class="text-left my-0">\
					<a href="https://www.youtube.com/channel/' + channelId + '">\
						<em>' + channel + '</em>\
					</a>\
				</p>\
				<p class="nbVideos text-left"></p>\
			</div>\
		</div>';

	});
	
	$('#search-results-authors').html(html);
}

function displayVideoInfos(){

	$('#search-results-videos-div > div').each(function(index, element){

		var videoId = $(element).attr('video');

		var url = 'https://www.googleapis.com/youtube/v3/videos';
		var params = {
			part: 'statistics,contentDetails',
			id: videoId,
			key:'AIzaSyCKqVcvBxViYhySoAa0ArgkjN0X1bucHmw'
		}

		$.getJSON(url, params, function (videoInfo) {
			$('#video-' + videoId + ' .viewCount').html(formatInt(videoInfo.items[0].statistics.viewCount));
			$('#video-' + videoId + ' .duration').html('Durée : ' + formatTime(videoInfo.items[0].contentDetails.duration));
		});
	});
}

function displayChannelInfos(){

	$('#search-results-authors > div').each(function(index, element){

		var channelId = $(element).attr('channel');

		var url = 'https://www.googleapis.com/youtube/v3/channels';
		var params = {
			part: 'statistics',
			id: channelId,
			key:'AIzaSyCKqVcvBxViYhySoAa0ArgkjN0X1bucHmw'
		}

		$.getJSON(url, params, function (channelInfo) {
			$('#channel-' + channelId + ' .nbVideos').html(formatInt(channelInfo.items[0].statistics.videoCount) + " vidéo(s)");
		});
	});
}

function displayResults(results) {

	var nbResults = results.pageInfo.totalResults;

	$('#search-results-title').html('Résultats');
	
	$('.page-previous').attr('token', results.prevPageToken);
	$('.page-next').attr('token', results.nextPageToken);

	var html = "";
	var entries = results.items;

	html += 
		'<p id="number-results" class="text-left">\
			<small>\
				Environ ' + formatInt(nbResults) + ' resultats\
			</small>\
		</p>';
	
	$.each(entries, function (index, value) {

		var title = value.snippet.title;
		var description = value.snippet.description;
		var channel = value.snippet.channelTitle;
		var thumbnail = value.snippet.thumbnails.medium.url;
		var videoId = value.id.videoId;
		var channelId = value.snippet.channelId;
		var publishedAt = new Date(value.snippet.publishedAt);
	 
		html += 
			'<div id="video-' + videoId + '" video="' + videoId + '" class="row p-2">\
				<div class="col-3 py-2 px-0">\
					<a href="https://www.youtube.com/watch?v=' + videoId + '">\
		 				<img src="' + thumbnail + '" style="width:100%;height:auto">\
					</a>\
				</div>\
				<div class="col-9">\
					<a href="https://www.youtube.com/watch?v=' + videoId + '">\
						<h4 class="text-left videoTitle">' + title + '</h4>\
					</a>\
					<p class="text-left my-0">\
						<vidChan class="videoAuthor bullet"><a href="https://www.youtube.com/channel/' + channelId + '">\
							<em>' + channel + '</em>\
						</a></vidChan>\
						<span class="viewCount videoViews bullet"> </span>\
						<vidDate class="videoDate bullet">Publiée le ' + formatDate(publishedAt.getDay(), publishedAt.getMonth() + 1, publishedAt.getFullYear() ) + '</vidDate>\
					</p>\
					<p class="text-left videoDescr">' + description + '</p>\
					<p class="duration text-left videoDuration"></p>\
				</div>\
			</div>';

	});
	
	$('#search-results-videos-div').html(html);
}

function formatTime(duration){
	return duration.substr(2).toLowerCase();
}

function formatDate(day, month, year){
	if(day < 10) day = "0" + day;
	if(month < 10) month = "0" + month;

	return day + '/' + month + '/' + year;
}

function formatInt(nStr){

	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ' ' + '$2');
	}
	
	return x1 + x2;
}