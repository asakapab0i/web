<?php
extract(joshlib());

function joshlib() {
	//look for joshlib at joshlib/index.php, ../joshlib/index.php, all the way down
	global $_josh;
	$count = substr_count($_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'], '/');
	for ($i = 0; $i < $count; $i++) if (@include(str_repeat('../', $i) . 'joshlib/index.php')) return $_josh;
	die('Could not find Joshlib.');
}
?>
<html>
	<head>
		<title>Window Size</title>
		<style>
			body { background-color: #6e779e; color: #b8bcd2; font-family:Helvetica, sans-serif; width: 100%; height: 100%; margin: 0; text-align: center; }
			#inner { position: absolute; top: 50%; left: 50%; width: 600px; height: 200px; margin: -100px 0 0 -300px; }
			#inner > div { float: left; margin: 0 20px; font-size: 48px; }
			#inner > div.times { line-height: 140px; }
			#inner > div div.number { color:#fff; font-size: 72px; }
		</style>
		<?=lib_get('jquery')?>
		<script>
			$(function(){
				function setWidth() {
					$("div.wide div.number").html($(window).width() + 'px');
					$("div.tall div.number").html($(window).height() + 'px');
				}
				
				$(window).on("click", function(){
					//eet window height
					myRef = window.open(''+self.location,'mywin','width=1024,height=700,toolbar=0,location=0,resizable=0');
				});
				setWidth();
				$(window).resize(setWidth);
			});
		</script>
	</head>
	<body>
		<div id="inner">
			<div class="wide">
				<div class="number"></div>
				WIDE
			</div>
			<div class="times">
				&times;
			</div>
			<div class="tall">
				<div class="number"></div>
				TALL
			</div>
		</div>
	</body>