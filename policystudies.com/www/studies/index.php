<?php
include('../include.php');

$start = $counter = 0;

if (url_id('download')) {
	$r = db_grab('SELECT title, type, file FROM user_documents WHERE is_active = 1 AND is_published = 1 AND id = ' . $_GET['download']);
	file_download($r['file'], $r['title'], $r['type']);
	exit;
} elseif (url_id()) {
	//show individual study

	$r = db_grab('SELECT
			t.title,
			t.release_date,
			t.description_1,
			t.topic_id,
			(SELECT COUNT(*) FROM user_staff_roles r WHERE r.is_active = 1 AND r.study_id = t.id) count_staff,
			(SELECT COUNT(*) FROM user_clients_roles r2 WHERE r2.is_active = 1 AND r2.study_id = t.id) count_clients,
			(SELECT COUNT(*) FROM user_documents d WHERE d.is_active = 1 AND d.study_id = t.id) count_documents,
			user_study_topics.title topic
		FROM user_studies t
		JOIN user_study_topics ON user_study_topics.id = t.topic_id
		WHERE t.is_active = 1 AND t.id = ' . $_GET['id']);
	echo drawTop($r['title']);
	
	$meta = array('Topic'=>draw_link('./?topic=' . $r['topic_id'], $r['topic']));
	
	//sponsors
	if ($r['count_clients'] == 1) {
		$clients = db_grab('SELECT c.id, c.title, c.url FROM user_clients c JOIN user_clients_roles r ON c.id = r.client_id WHERE r.is_active = 1 AND r.study_id = ' . $_GET['id']);
		$meta['Sponsor'] = draw_link($clients['url'], $clients['title']);
	} elseif ($r['count_clients']) {
		$clients = db_table('SELECT c.id, c.title, c.url FROM user_clients c JOIN user_clients_roles r ON c.id = r.client_id WHERE r.is_active = 1 AND r.study_id = ' . $_GET['id'] . ' ORDER BY r.precedence');
		foreach ($clients as &$c) $c = draw_link($c['url'], $c['title']);
		$meta['Sponsors'] = format_array_text($clients);
	}
	
	if ($r['release_date']) $meta['Completed'] = format_date($r['release_date'], false, '%B %Y');

	//staff
	if ($r['count_staff'] == 1) {
		$s = db_grab('SELECT s.id, s.full_name, s.is_published FROM user_staff_roles r JOIN user_staff s ON s.id = r.staff_member_id WHERE r.is_active = 1 AND r.study_id = ' . $_GET['id']);
		$meta['PSA Director'] = ($s['is_published']) ? draw_link('/staff/?id=' . $s['id'], $s['full_name']) : $s['full_name'];
	} elseif ($r['count_staff']) {
		$staff = db_table('SELECT s.id, s.full_name, s.is_published FROM user_staff_roles r JOIN user_staff s ON s.id = r.staff_member_id WHERE r.is_active = 1 AND r.study_id = ' . $_GET['id'] . ' ORDER BY r.precedence');
		foreach ($staff as &$s) $s = ($s['is_published']) ? draw_link('/staff/?id=' . $s['id'], $s['full_name']) : $s['full_name'];
		$meta['PSA Directors'] = format_array_text($staff);
	}

	//documents
	if ($r['count_documents']) {
		$documents = db_table('SELECT d.id, d.title, d.type, ' . db_updated('d') . ' FROM user_documents d WHERE d.study_id = ' . $_GET['id'] . ' AND d.is_active = 1 AND d.is_published = 1 ORDER BY d.precedence');
		foreach ($documents as &$d) $d = draw_link(url_query_add(array('download'=>$d['id']), false), file_icon($d['type']) . $d['title']);
		$meta['Downloads'] = draw_list($documents);
	}

	if ($r['release_date']) $r['Completion Date'] = format_date($r['release_date'], '', '%B %Y', false);
		
	echo draw_dl($meta);
	echo $r['description_1'];
	if (user()) echo draw_link('/login/object/edit/?id=' . $_GET['id'] . '&object_id=2', 'Edit This Study', false, array('class'=>'cms'));
} elseif (url_id('topic')) {
	//or show topic study list
	$topic = db_grab('SELECT title, detailed_description FROM user_study_topics WHERE id= ' . $_GET['topic']);
	echo drawTop($topic['title']);

	echo $topic['detailed_description'];
	
	$studies = db_table('SELECT 
			s.id, 
			s.title,
			s.release_date
		FROM user_studies s
		WHERE s.is_active = 1 AND s.is_published = 1 AND s.topic_id = ' . $_GET['topic'] . '
		ORDER BY s.release_date DESC');
		
	$t = new table('studies');
	$t->set_column('release_date');
	$t->set_column('title');
	
	foreach ($studies as &$s) {
		if ($s['release_date']) {
			$s['group'] = 'Completed Studies';
			$s['release_date'] = format_date($s['release_date'], '', '%B %Y', false);
		} else {
			$s['release_date'] = 'In Progress';
			if (!$start) $start = $counter;
			$s['group'] = 'Studies In Progress';
		}
		$s['title'] = draw_link('./?id=' . $s['id'], $s['title']);
		$counter++;
	}
	$inprog = array_slice_assoc($studies, $start, ($counter - $start));
	$completed = array_slice_assoc($studies, 0, $start);
	$studies = array_merge($inprog, $completed);

	echo $t->draw($studies);
	
} elseif (isset($_GET['type']) && ($_GET['type'] == 'all')) {
	//or show topic study list

	echo drawTop('All Studies');

	echo draw_container('h2', '');
	
	$studies = db_table('SELECT 
			s.id, 
			s.title,
			s.release_date
		FROM user_studies s
		WHERE s.is_active = 1 AND s.is_published = 1
		ORDER BY s.release_date DESC');
		
	$t = new table('studies');
	$t->set_column('release_date');
	$t->set_column('title');
	
	foreach ($studies as &$s) {
		if ($s['release_date']) {
			$s['group'] = 'Completed Studies';
			$s['release_date'] = format_date($s['release_date'], '', '%B %Y', false);
		} else {
			if (!$start) $start = $counter;
			$s['group'] = 'Studies In Progress';
			$s['release_date'] = 'In Progress';
		}
		$s['title'] = draw_link('./?id=' . $s['id'], $s['title']);
		$counter++;
	}
	$inprog = array_slice_assoc($studies, $start, ($counter - $start));
	$completed = array_slice_assoc($studies, 0, $start);
	$studies = array_merge($inprog, $completed);
	
	echo $t->draw($studies);
	
} else {
	echo drawTop('Studies');

	//or show the option types
	$types = db_table('SELECT id, title, description FROM user_study_topics WHERE is_active = 1 ORDER BY precedence');
	foreach ($types as &$t) $t = '<h3>' . draw_link('/studies/?topic=' . $t['id'], $t['title']) . '</h3>' . $t['description'];
	echo draw_list($types, 'text_list');
	echo drawSnippet(7);
}

echo drawBottom();

?>