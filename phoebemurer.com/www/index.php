<?php
@extract(joshlib()) or die("Can't locate library! " . $_SERVER["DOCUMENT_ROOT"]);

function joshlib() {
	global $_josh;
	$possibilities = array(
		"/home/phoebemurer/www/joshlib/index.php", //icd phoebe
		"/Users/joshreisner/Sites/joshlib/index.php", //josh dev
		"/home/joshreisner/www/joshlib/index.php" //icd josh
	);
	foreach ($possibilities as $p) if (@include($p)) return $_josh;
	return false;
}

if (url_id() && ($request['folder'] == 'paintings')) {
	$painting = db_grab('SELECT 
				p.title,
				p.category_id,
				p.caption,
				c.title category,
				c.description category_description,
				(SELECT p2.id FROM user_paintings p2 WHERE p2.is_active = 1 AND p2.is_published = 1 AND p2.category_id = p.category_id ORDER BY p2.precedence LIMIT 1) first,
				(SELECT p2.id FROM user_paintings p2 WHERE p2.precedence < p.precedence AND p2.is_active = 1 AND p2.is_published = 1 AND p2.category_id = p.category_id ORDER BY p2.precedence DESC LIMIT 1) prev,
				(SELECT p2.id FROM user_paintings p2 WHERE p2.precedence > p.precedence AND p2.is_active = 1 AND p2.is_published = 1 AND p2.category_id = p.category_id ORDER BY p2.precedence LIMIT 1) next,
				' . db_updated('p') . '
			FROM user_paintings p
			JOIN user_painting_categories c ON p.category_id = c.id
			WHERE p.id = ' . $_GET['id']);
	$painting['first'] = '/paintings/?id=' . $painting['first'];
} else {
	$painting['first'] = false;
}
echo url_header_utf8() . draw_doctype();
?>
	<head>
		<?=draw_meta_utf8()?>
		<title>Phoebe M&uuml;rer</title>
		<link rel="stylesheet" href="/styles/screen.css"/>
		<script language="javascript" src="/javascript.js"></script>
	</head>
	<?=draw_body_open()?>
		<div id="container">
			<div id="header">
				<div id="logo"><?=draw_img("/images/logo.png", "/")?></div>
				<?
				$options = array("paintings", "audio", "info");
				$counter = 0;
				foreach ($options as $o) {
					$counter++;
					echo '<div class="section ' . $o . '">
					<div class="tag"><span class="super">' . $counter . '</span>' . strToUpper($o) . '_</div>
					<div class="options">';
					if ($o == 'paintings') {
						echo draw_nav('SELECT CONCAT("/paintings/?id=", (SELECT p.id FROM user_paintings p WHERE p.category_id = c.id AND p.is_active = 1 AND p.is_published = 1 ORDER BY p.precedence LIMIT 1)) url, c.title FROM user_painting_categories c WHERE c.is_active = 1 AND c.is_published = 1 ORDER BY c.precedence', 'text', 'nav', $painting['first']);
					} elseif ($o == 'audio') {
						echo draw_nav('SELECT CONCAT("/audio/?id=", a.id) url, a.title FROM user_audio a WHERE a.is_active = 1 AND a.is_published = 1 ORDER BY a.precedence');
					} elseif ($o == 'info') {
						echo draw_nav('SELECT CONCAT("/info/?id=", i.id) url, i.title FROM user_info_pages i WHERE i.is_active = 1 AND i.is_published = 1 ORDER BY i.precedence');
					}
					echo '</div></div>';
				}
				?>
			</div>
			<div id="left">
			<?
			//side navigation
			$paintings = false;
			if (url_id() && ($request['folder'] == 'paintings')) {
				if (!empty($painting['next'])) $painting['next'] = '/paintings/?id=' . $painting['next'];
				if (!empty($painting['prev'])) $painting['prev'] = '/paintings/?id=' . $painting['prev'];
				echo "<div id='description'><div class='separator'>---</div><span class='top'>";
				echo $painting['category'] . '_<br></span>';
				if (!empty($painting['category_description'])) {
					echo '<span class="top">TEXT <a onclick="javascript:text_change(false);"';
					if (!isset($_COOKIE["text_closed"])) echo " class='selected'";
					echo " id='openLink'>OPEN</a> / <a onclick='javascript:text_change(true);'";
					if (isset($_COOKIE["text_closed"])) echo " class='selected'";
					echo " id='closeLink'>CLOSE</a><br><br></span>";
					
					echo "<div id='text' style='display:";
					echo (isset($_COOKIE["text_closed"])) ? "none" : "block";
					echo ";'>" . $painting['category_description'] . "</div>";
				}
				echo "</div>";
				if ($paintings = db_table('SELECT id, title, ' . db_updated() . ' FROM user_paintings WHERE category_id = ' . $painting['category_id'] . ' AND is_active = 1 AND is_published = 1 ORDER BY precedence')) {
					echo "<div id='gallery'><div class='separator'>---</div>";
	
					//todo replace with draw_nav					
					$javascript = '';
					foreach ($paintings as $p) {
						$bright	= file_dynamic('user_paintings', 'thumb_bright', $p['id'], 'jpg', $p['updated']);
						$dim	= file_dynamic('user_paintings', 'thumb_dim', $p['id'], 'jpg', $p['updated']);
						$name	= 'img_' . $p['id'];
						if ($p['id'] == $_GET['id']) {
							echo draw_img($bright, false, false, $name);
						} else {
							$javascript .= $name . '_on			= new Image;' . NEWLINE;
							$javascript .= $name . '_off		= new Image;' . NEWLINE;
							$javascript .= $name . '_on.src		= \'' . $bright . '\';' . NEWLINE;
							$javascript .= $name . '_off.src	= \'' . $dim . '\';' . NEWLINE;
							echo '<a onmouseover="roll(\'' . $name . '\', \'on\')" onmouseout="roll(\'' . $name . '\', \'off\')" href="/paintings/?id=' . $p['id'] . '">' . draw_img($dim, false, false, $name) . '</a>';
						}
					}
					echo draw_javascript("if (document.images) {" . $javascript . "}");
					echo "</div>";
				}
			} elseif (!$_josh["request"]["folder"])	{
				//echo "<div id='description'><div class='separator'>---</div></div>";
			}
			?>
			</div>
			<div id="main">
				<div id='mininav'><? if ($paintings) {
				if ($painting['prev']) echo '<a href="' . $painting['prev'] . '">';
				echo "&lt;";
				if ($painting['prev']) echo '</a>';
				echo " / ";
				if ($painting['next']) echo '<a href="' . $painting['next'] . '">';
				echo "&gt;";
				if ($painting['next']) echo '</a>';
				} ?></div>
				<?
				if ($paintings) { //display gallery image
					echo draw_img(file_dynamic('user_paintings', 'image', $_GET['id'], 'jpg', $painting['updated']), $painting['next']);
					echo "<div class='separator'>---</div>" . $painting['caption'];
				} elseif (url_id() && ($request['folder'] == 'audio')) {
					$audio = db_grab('SELECT caption, ' . db_updated() . ' FROM user_audio WHERE id = ' . $_GET['id']);
					echo draw_audio_embed(file_dynamic('user_audio', 'mp3_file', $_GET['id'], 'mp3', $audio['updated']));
					echo "<div class='separator'>---</div>" . $audio['caption'];
				} elseif (url_id() && ($request['folder'] == 'info')) {
					echo db_grab('SELECT content FROM user_info_pages WHERE id = ' . $_GET['id']);
				} elseif (home()) { //home page
					echo draw_link('/paintings/?id=32', draw_img('/images/home/iceland.jpg'), false, array('style'=>'position:absolute;left:176px;top:0px;'));
					echo draw_link('/paintings/?id=82', draw_img('/images/home/rat.jpg'), false, array('style'=>'position:absolute;left:0px;top:160px;'));
					echo draw_link('/paintings/?id=83', draw_img('/images/home/wii.jpg'), false, array('style'=>'position:absolute;left:656px;top:160px;'));
					echo draw_link('/paintings/?id=84', draw_img('/images/home/bears.jpg'), false, array('style'=>'position:absolute;left:240px;top:236px;'));
				}
				?>
			</div>
		</div>
		<?=draw_google_tracker("UA-80350-13")?>
	</body>
</html>