<?php
include('../include.php');

if (url_id()) {
	if (!$a = db_grab('SELECT 
			title, 
			year_created, 
			width, height, 
			depth, precedence, 
			' . db_updated() . ',
			(SELECT MAX(precedence) FROM user_artworks) max_precedence 
		FROM user_artworks
		WHERE is_active = 1 AND id = ' . $_GET['id'])) url_change('./');

	echo drawTop($a['title']);
	//get next and previous image thumbnails
	$prevImg = $nextImg = '';
	if ($a['precedence'] != 1) {
		$prevImg = db_grab('SELECT id FROM user_artworks WHERE precedence = ' . ($a['precedence'] - 1));
		$prevImg = draw_img(file_dynamic('user_artworks', 'thumbnail_img', $prevImg, 'jpg', $a['updated']), './?id=' . $prevImg);
	}
	if ($a['precedence'] != $a['max_precedence']) {
		$nextImg = db_grab('SELECT id FROM user_artworks WHERE precedence = ' . ($a['precedence'] + 1));
		$nextImg = draw_img(file_dynamic('user_artworks', 'thumbnail_img', $nextImg, 'jpg', $a['updated']), './?id=' . $nextImg);
	}
	?>
	<div id="page_white">
		<div class="inner">
			<div class="artworkname"><?=$a['title']?></div>
			<div class="artworkdetails"><?=$a['year_created']?> —
				<?=$a['width']?> <font color="#b19d83">wide</font>
				<?=$a['height']?> <font color="#b19d83">tall</font>
				<?=$a['depth']?> <font color="#b19d83">deep
			</div>
			<div id="thumbnail1" class="thumbnail"><?=$prevImg?></div>
			<div id="thumbnail2" class="thumbnail"><?=$nextImg?></div>
		</div>
		<?=draw_div('artwork', draw_img(file_dynamic('user_artworks', 'main_img', $_GET['id'], 'jpg', $a['updated'])))?>
	</div>
<?php
} else {
	echo drawTop();
	//list page
	$artworks = db_table('SELECT id, title, ' . db_updated() . ' FROM user_artworks WHERE is_active = 1 AND is_phial <> 1 ORDER BY precedence');
	foreach ($artworks as &$a) $a = draw_img(file_dynamic('user_artworks', 'list_img', $a['id'], 'jpg', $a['updated']), './?id=' . $a['id'], $a['title']);
	$phials = db_table('SELECT id, title, ' . db_updated() . ' FROM user_artworks WHERE is_active = 1 AND is_phial = 1 ORDER BY precedence');
	foreach ($phials as &$a) $a = draw_img(file_dynamic('user_artworks', 'list_img', $a['id'], 'jpg', $a['updated']), './?id=' . $a['id']);
	echo draw_div('page', 
		draw_list($artworks, 'artworks') . 
		draw_div('clausum', '<i>Musæum Clausum</i> (in Latin, "hidden museum" or "sealed museum"), also known as <i>Bibliotheca Abscondita</i> or Tract XIII, is the title of a "list of lost curiosities" composed by Sir Thomas Browne in the 17th century and published posthumously in 1684.  Browne tells us in his subtitle that the tract contains "Some remarkable Books, Antiquities, Pictures and Rarities of several kinds, scarce or never seen by any man now living."  The Musæum includes such items as "A small vial of water taken out of the stones therefore called <i>enhydri</i>, which naturally include a little water in them in like manner as the <i>aetites</i> or eagle stone doth another stone"; "An extract of the ink of cuttlefishes, reviving the old remedy of Hippocrates in hysterical passions"; "Spirits and salt of Sargasso made in the western ocean, covered with that vegetable; excellent against the scurvy"; "A <i>clepselaea</i>, or oil hourglass, as the ancients used those of water"; "A ring found in a fish\'s belly taken about Goro, conceived to be the same wherewith the Duke of Venice had wedded the sea"; and "A glass of spirits, made of ethereal salt, hermetically sealed up, kept continually in quicksilver; of so volatile a nature that it will scarce endure the light, and therefore only to be shown in winter, or by the light of a carbuncle or Bononian stone.') .
		draw_list($phials, 'artworks')
	);
}

echo drawBottom();