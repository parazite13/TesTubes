<!DOCTYPE html>
<html>

<head>
	<?php getHead(); ?>
	<title>Video</title>
</head>

<body>
	
	<?php getHeader(); ?>

	<?php if(isset($_GET['v'])): ?>
		
		<?php
		$port = file_get_contents(ABSPATH.'port.txt');
		file_put_contents(ABSPATH.'port.txt', $port+1);
		$video = $_GET['v'];
		if($port > 1005){
			file_put_contents(ABSPATH.'port.txt', 1000);
		}
		execInBackground('"C:\Program Files\VideoLAN\VLC\vlc.exe" https://www.youtube.com/watch?v='.$video.' :sout=#transcode{vcodec=theo,vb=800,acodec=vorb,ab=128,channels=2,samplerate=44100}:http{mux=ogg,dst=:'.$port.'/} :sout-keep'); 
		?>

		<div class="container">
			<div style="margin-top: 80px;">
				<video id="video" controls="" autoplay="" port="<?= $port ?>" style="width: 100%">
					<source src="http://testubes:<?= $port ?>"/>
				</video>
			</div>

			<?php if(isConnected()):?>
				<div class="form-group container-fluid">
					<label for="myComment">Votre commentaire : </label>
					<textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
				</div>
				<button class="btn btn-success" role="button" onclick="checkComment()">Publier</button>
			<?php endif ?>

			<?php 
			$array = $api->getComments($video);
			$query = "SELECT `id`, `pseudo` FROM `users` WHERE ";
			foreach($array as $comment) $query .= "`id`=" . $comment->id_user . " OR ";
			$query = substr($query, 0, -3);
			$comments = $db->getRowsFromQuery($query);
			foreach ($array as $comment): ?>
			<div class="main-com">
				<div class="row mt-2">
					<div class="col-12 header-com">
						Écrit par <b><?=$comments[$comment->id_user]?></b> à <?=$comment->date?>
					</div>
				</div>
				<div class="row">
					<div class="col-12 com">
						<?=$comment->comment;?>
					</div>
				</div>
			</div>
			<?php endforeach?>

		</div>

		<script type="text/javascript">
			$(window).bind('beforeunload', function(e){
	  			$.post("ajax/killProcess.php", {port: $('#video').attr('port')});
			});


			function checkComment(){
				var url = 'ajax/checkComment.php';
				var idVideo = '<?=$video?>';
				var myComment = $('#comment').val();
				$.get(url, {id_video:idVideo, comment:myComment}, function(results){
					console.log(results);
				});
			}

		</script>

	<?php else: ?>

		<p style="margin-top:80px;">Vous n'avez pas renseigné de vidéo (abruti...)</p>

	<?php endif; ?>


	<?php getFooter(); ?>

</body>

</html>
