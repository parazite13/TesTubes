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
		execInBackground('"'.VLC_PATH.'" https://www.youtube.com/watch?v='.$video.' :sout=#transcode{vcodec=theo,vb=800,acodec=vorb,ab=128,channels=2,samplerate=44100}:http{mux=ogg,dst=:'.$port.'/} :sout-keep'); 
		?>

		<div class="container">
			<div style="margin-top: 80px;">
				<video id="video" autoplay="" port="<?= $port ?>" style="width: 100%">
					<source src="http://testubes:<?= $port ?>"/>
				</video>
				<div style="width: 100%">
					<button role="button" class="btn play-pause"><i class="fa fa-pause" aria-hidden="true"></i></button>
					<div class="progress">
						<?php foreach($api->getComments($video) as $comment): ?>
							<div class="comment-cursor" time="<?=$comment->time_video?>"></div>
						<?php endforeach; ?>
						<div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
					<button role="button" class="btn fullscreen"><i class="fa fa-arrows-alt" aria-hidden="true"></i></button>
				</div>
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
					<div class="card-header col-12 header-com">
						Écrit par <b><?=$comments[$comment->id_user]?></b> (<?=$comment->date?>)
					</div>
					<div class="card-block col-12 com">
						<?=$comment->comment;?>
					</div>
				</div>
				<?php endforeach?>
			</div>
		</div>

		<script type="text/javascript">
			var duration;

			$(document).ready(function(){
				setInterval(function(){
					var time = $('#video')[0].currentTime;
					var comments = $('.main-com');
					$.each(comments, function(index, comment){
						if(parseInt($(this).attr('time')) < time ){
							$(this).fadeIn(1000, function(){
								$(this).removeClass("dnone");
							});
						}
					});

					$('.progress-bar').css('width', ($('#video')[0].currentTime * 100/ duration) + "%")

				}, 1000);

				$('.play-pause').click(function(){
					var video = $('#video');
					var icon = $(this).find('i');
					if(video[0].paused){
						video[0].play();
						icon.removeClass('fa-play');
						icon.addClass('fa-pause');
					}else{
						video[0].pause();
						icon.removeClass('fa-pause');
						icon.addClass('fa-play');
					}
				});

				$('.fullscreen').click(function(){
					$('#video')[0].webkitRequestFullScreen();
				});

				var videoId = '<?= isset($_GET['v']) ? $_GET['v'] : ''?>';

				var url = 'https://www.googleapis.com/youtube/v3/videos';
				var params = {
					part: 'contentDetails',
					id: videoId,
					key:'AIzaSyCKqVcvBxViYhySoAa0ArgkjN0X1bucHmw'
				}

				$.getJSON(url, params, function (videoInfo) {
					duration = videoInfo.items[0].contentDetails.duration;
					var regex = /PT([0-9]*)H?([0-9]*)M?([0-9]*)S/;
					var matches = duration.match(regex);

					var min = 0;
					var sec = 0;
					var hour = 0;

					if(matches[2] == ""){

						// seconde
						if(matches[3] == ""){
							sec = matches[1];

						// minute et seconde
						}else{
							min = matches[1];
							sec = matches[3];
						}

					// heure minute et seconde
					}else{
						hour = matches[1];
						min = matches[2];
						sec = matches[3];
					}

					duration = parseInt(hour) * 3600 + parseInt(min) * 60 + parseInt(sec);

					$.each($('.progress .comment-cursor'), function(index, comment){

						var time = parseInt($(comment).attr('time'));
						$(comment).css('left', (time * 100 / duration) + "%");

					});
				});
			});

			$(window).bind('beforeunload', function(e){
	  			$.post("ajax/killProcess.php", {port: $('#video').attr('port')});
			});

			function checkComment(){
				if($('#comment').val().length > 0){
					var url = 'ajax/checkComment.php';
					var idVideo = '<?=$video?>';
					var myComment = $('#comment').val();
					$('#comment').val('');
					var timeComment = $('#video')[0].currentTime;
					var date = new Date();
						var html = '<div class="main-com card mt-2" time="' + timeComment + '">\
										<div class="card-header">\
											<div class="col-12 header-com">\
												Écrit par <b><?=isset($_SESSION["pseudo"])?$_SESSION["pseudo"]:""?></b> ( ' + date.getFullYear() + '-' + (date.getMonth() + 1).toString().lpad('0', 2) + '-' + date.getDate().toString().lpad('0', 2) + ' ' + date.getHours().toString().lpad('0', 2) + ':' + date.getMinutes().toString().lpad('0', 2) + ':' + date.getSeconds().toString().lpad('0', 2) + ')\
											</div>\
										</div>\
										<div class="card-block">\
											<div class="col-12 com">\
												' + myComment + '\
											</div>\
										</div>\
									</div>'
					$.get(url, {id_video:idVideo, comment:myComment, chrono:timeComment}, function(results){
						var allDnone = $('.comments-block').find('.dnone');
						if(allDnone.length > 0){
							$(allDnone[allDnone.length - 1]).after(html);
						}else{
							$('.comments-block').prepend(html);
						}
					});
				}
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

		<p style="margin-top:80px;">Vous n'avez pas renseigné de vidéo ...</p>

	<?php endif; ?>


	<?php getFooter(); ?>

</body>

</html>
