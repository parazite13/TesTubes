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
					<label>Votre commentaire : </label>
					<textarea class="form-control" id="comment" rows="3"></textarea>
				</div>
				<button class="btn btn-success" role="button" onclick="checkComment()">Publier</button>
			<?php endif ?>

			<div class="comments-block">
				<?php 
				$array = $api->getComments($video);
				$query = "SELECT `id`, `pseudo` FROM `users` WHERE ";
				foreach($array as $comment) $query .= "`id`=" . $comment->id_user . " OR ";
				$query = substr($query, 0, -3);
				$results = $db->getRowsFromQuery($query, false);
				$comments = array();
				foreach($results as $result) $comments[$result['id']] = $result['pseudo']; ?>
				<?php foreach ($array as $comment): ?>
				<div class="main-com card mt-2 dnone" time="<?=$comment->time_video?>">
					<div class="card-header">
						<div class="col-12 header-com">
							Écrit par <b><?=$comments[$comment->id_user]?></b> à <?=$comment->date?>
						</div>
					</div>
					<div class="card-block">
						<div class="col-12 com">
							<?=$comment->comment;?>
						</div>
					</div>
				</div>
				<?php endforeach?>
			</div>
		</div>

		<script type="text/javascript">
			var chrono;
			$(document).ready(function(){
				chrono = new Timer();
				chrono.run();
				setInterval(function(){
					var time = parseInt(chrono.min) * 60 + parseInt(chrono.sec);
					var comments = $('.main-com');
					$.each(comments, function(index, comment){
						if(parseInt($(this).attr('time')) < time ){
							$(this).fadeIn(1000, function(){
								$(this).removeClass("dnone");
							});
						}
					});
				}, 1000);
			});

			$(window).bind('beforeunload', function(e){
	  			$.post("ajax/killProcess.php", {port: $('#video').attr('port')});
			});

			function checkComment(){
				var url = 'ajax/checkComment.php';
				var idVideo = '<?=$video?>';
				var myComment = $('#comment').val();
				var timeComment = parseInt(chrono.min) * 60 + parseInt(chrono.sec);
				$.get(url, {id_video:idVideo, comment:myComment, chrono:timeComment}, function(results){
					console.log(results);
				});
			}

			function Timer(){
				this.dateStartChrono = new Date();
				this.end;
				this.diff;
				this.min;
				this.sec;
				this.msec;
				this.timerID;
				this.run = function(){
					this.end = new Date();
					this.diff = this.end - this.dateStartChrono;
					this.diff = new Date(this.diff);
					this.msec = this.diff.getMilliseconds();
					this.sec = this.diff.getSeconds();
					this.min = this.diff.getMinutes();
					if (this.min < 10){
						this.min = "0" + this.min;
					}
					if (this.sec < 10){
						this.sec = "0" + this.sec;
					}
					if(this.msec < 10){
						this.msec = "00" +this.msec;
					}
					else if(this.msec < 100){
						this.msec = "0" +this.msec;
					}
					this.timerID = setTimeout(this.run.bind(this), 10);
				}
				this.reset = function(){
					clearTimeout(this.timerID);
					this.min = '00';
					this.sec = '00';
					this.msec = '00';
				}
				this.pause = function(){
					clearTimeout(this.timerID);
				}
				this.resume = function(){
					this.dateStartChrono = new Date() - this.diff;
					this.dateStartChrono = new Date(this.dateStartChrono);
					this.run();
				}
			}
		</script>

	<?php else: ?>

		<p style="margin-top:80px;">Vous n'avez pas renseigné de vidéo (abruti...)</p>

	<?php endif; ?>


	<?php getFooter(); ?>

</body>

</html>
