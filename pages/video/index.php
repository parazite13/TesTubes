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
		</div>

		<script type="text/javascript">
		$(window).bind('beforeunload', function(e){
  			$.post("ajax/killProcess.php", {port: $('#video').attr('port')});
		});
		</script>

	<?php else: ?>

		<p style="margin-top:80px;">Vous n'avez pas renseigné de vidéo (abruti...)</p>

	<?php endif; ?>


	<?php getFooter(); ?>

</body>

</html>
