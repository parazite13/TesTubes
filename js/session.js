$(document).ready(function(){
	
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