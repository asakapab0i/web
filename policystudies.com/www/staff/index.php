<?php
include('../include.php');

if (url_id()) {
	$r = db_grab('SELECT full_name, email, phone, bio FROM user_staff WHERE id = ' . $_GET['id']);
	echo drawTop($r['full_name']);
	
	echo draw_dl(array(
		'Email'=>draw_link('mailto:' . $r['email']),
		'Telephone'=>format_phone($r['phone'])
	));
	echo $r['bio'];
} else {
	echo drawTop('Staff');
	
	echo drawSnippet(4);
	
	$t = new table('user_staff');
	$t->set_column('name');
	//$t->set_column('email');
	$t->set_column('phone');
	
	$staff = db_table('SELECT s.id, s.lastname_first, s.title, s.email, s.phone, IFNULL(s.updated_date, s.created_date) updated, t.title "group" FROM user_staff s JOIN user_staff_types t ON s.type_id = t.id WHERE s.is_active = 1 AND s.is_published = 1 ORDER BY t.precedence, s.lastname_first');
	foreach ($staff as &$s) {
		$s['name'] = draw_link('./?id=' . $s['id'], $s['lastname_first']);
		if ($s['title']) $s['name'] .= draw_span('title', $s['title']);
		//$s['email'] = draw_link('mailto:' . $s['email']);
	}
	echo $t->draw($staff);
}

echo drawBottom();
?>