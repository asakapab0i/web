<?php
include('../include.php');

$set = db_grab('SELECT id, title, pub_date FROM user_practice_sets WHERE is_active = 1 AND is_published = 1 AND pub_date < NOW() ORDER BY pub_date DESC');

$practices = db_table('SELECT id, title, description, closing FROM user_practices WHERE is_active = 1 AND practice_set_id = ' . $set['id'] . ' ORDER BY precedence');

foreach ($practices as &$p) {
	$questions = db_table('SELECT q.id, q.title, q.answer, t.title type, q.feedback FROM user_questions q JOIN user_question_types t ON q.type_id = t.id WHERE q.is_active = 1 AND q.practice_id = ' . $p['id'] . ' ORDER BY q.precedence');
	foreach ($questions as &$q) {
		$q = '<question id="' . $q['id'] . '" answer="' . $q['answer'] . '" type="' . strToLower($q['type']) . '" feedback="' . $q['feedback'] . '">' . $q['title'] . '</question>';
	}
	
	$quote = db_grab('SELECT quote, credit FROM user_quotes WHERE practice_id = ' . $p['id'] . ' AND is_active = 1 ORDER BY RAND()');
	
	$p = '<practice title="' . $p['title'] . '">
		<header>' . $p['description'] . '</header>
		' . implode(NEWLINE, $questions) . '
		<closing>' . $p['closing'] . '</closing>
		<quote>' . $quote['quote'] . '</quote>
		<credit>- ' . $quote['credit'] . '</credit>
		</practice>';
}

echo '<?xml version="1.0" encoding="UTF-8"?><practices lastBuildDate="' . format_date_rss($set['pub_date']) . '">' . implode(NEWLINE, $practices) . '</practices>';