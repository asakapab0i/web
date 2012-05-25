<?php
include('include.php');
echo drawTop();

$studies = db_table('SELECT id, title, home_blurb FROM user_studies WHERE feature = 1 AND is_published = 1 AND is_active = 1 ORDER BY release_date DESC');
foreach ($studies as &$s) $s = draw_container('p', draw_container('h3', draw_link('/studies/?id=' . $s['id'], $s['title'])) . $s['home_blurb']);

echo draw_div('home', 
	$google_form . 
	
	'<div id="column_left" class="column">
		' . draw_img('/images/logo-home.png', false, array('class'=>'logo')) . '
		<div class="band">' . draw_nav(array_slice_assoc($sections, 0, 3)) . '</div>
		<div class="studies">
			<p class="heading">' . drawSnippet(2) . '</p>
			' . implode('', array_slice($studies, 0, 2)) . '
		</div>
	</div>
	<div id="column_right" class="column">
		' . drawSnippet(1) . '
		<div class="band">' . draw_nav(array_slice_assoc($sections, 3, 3)) . '</div>
		<div class="studies">
			' . implode('', array_slice($studies, 2)) . 
			drawSnippet(8) . '
		</div>
	</div>
	<div id="footer">
		Copyright &copy; ' . $year . ' Policy Studies Associates, Inc.
	</div>
');

echo drawBottom();
