<?php
//sys functions

function josh_sys_action($action, $id=false, $array=false) {
	//this is joshserver's GET and POST display logic
	global $_josh, $_COOKIE;
	josh_sys_debug("<b>josh_sys_action</b> with action <b>$action</b>");
	$redirect	= (isset($array["redirect"])) ? $array["redirect"] : false;
	if (isset($array["pageID"])) {
		if (empty($array["parameter"]))	$array["parameter"] = "";
		if (empty($array["scroll"]))	$array["scroll"] = "";
		$id_string	= $array["pageID"] . "_" . $array["parameter"] . "_" . $array["scroll"];
	} else {
		$id_string = "";
	}
	$parameter	= false;
	$scroll		= false;
	if ($id) @list($id, $parameter, $scroll) = explode("_", $id);
	if (($action == "approve") && $_josh["user"]) {
		$redirect = josh_sys_approve($id, $parameter);
	} elseif (($action == "approve_all") && $_josh["user"]) {
		$pages = josh_db_query("SELECT id FROM josh_pages WHERE content_dev <> content_live AND siteID = " . $_josh["site"]["id"]);
		while ($p = josh_db_fetch($pages)) josh_sys_approve($p["id"]);
		$redirect = "/j/draw_manage/";
	} elseif (($action == "backup") && $_josh["user"]) {
		echo josh_xml_backup_generate();
		exit;
	} elseif ($action == "contact_admin") {
		$message  = "enter your email address and message below. " . strToLower($_josh["system"]["admin_name"]) . " should respond to you shortly.<br><br>";
		$form = new josh_draw_table_form;
		if ($_josh["system"]["sites_num"] > 1) $form->add_hidden("server", '<a href="' . $_josh["site"]["full_url"] . '/">' . $_josh["site"]["url"] . '</a>');
		$form->set_dimensions(290,100);
		$form->add_row("text", "email");
		$form->add_row("textarea", "message");
		$message .= $form->draw("contact_admin_send", "send message");
		echo josh_draw_page("contact admin", $message);
	} elseif ($action == "contact_admin_send") {
		josh_sys_email_postdata("joshserver <" . $array["email"] . ">", $_josh["system"]["admin_email"], "contacting joshserver admin");
		$redirect = "/j/message_sent/";
	} elseif ($action == "css") {
		$what = ($_josh["user"]) ? "dev" : "live";
		josh_sys_die($_josh["site"]["css_" . $what], "css");
	} elseif (($action == "destroy") && $_josh["user"]) {
		$message  = "clicking this button will delete all your sites on this server. ";
		if ($_josh["system"]["sites_num"] == 1) {
			$message .= "you might want to " . josh_format_link("back up your content", "backup") . " first.";
		} else {
			$message .= "you might want to back up your content first.<ul>";
			$sites = josh_db_query("SELECT url FROM josh_sites ORDER BY url");
			while ($s = josh_db_fetch($sites)) $message .= "<li>" . josh_format_link($s["url"], $s["url"] . "/j/backup", false, "josh_dark", true);
			$message .= "</ul>";
		}
		$message .= " there is no undoing this step.<br><br>";
		$form = new josh_draw_table_form;
		$message .= $form->draw("destroy_exec", "start over");
		echo josh_draw_page("start over?", $message, true);
	} elseif (($action == "destroy_exec") && $_josh["user"]) {
		//server
		josh_db_query("DROP TABLE josh_users");
		josh_db_query("DROP TABLE josh_pages");
		josh_db_query("DROP TABLE josh_sites");
		josh_db_query("DROP TABLE josh_system");
		josh_db_query("DROP TABLE josh_users_to_sites");
		
		//objects
		josh_db_query("DROP TABLE josh_objects_types");
		josh_db_query("DROP TABLE josh_objects_types_to_sites");
		josh_db_query("DROP TABLE josh_objects");
		josh_db_query("DROP TABLE josh_fields");
		josh_db_query("DROP TABLE josh_fields_types");
		josh_db_query("DROP TABLE josh_flags");
		josh_db_query("DROP TABLE josh_flags_types");
		josh_db_query("DROP TABLE josh_instances");
		josh_db_query("DROP TABLE josh_instances_to_flags");
		josh_db_query("DROP TABLE josh_instances_to_words");
		josh_db_query("DROP TABLE josh_words");
	} elseif (($action == "discard") && $_josh["user"]) {
		$redirect = josh_sys_discard($id, $parameter);
	} elseif (($action == "discard_all") && $_josh["user"]) {
		$pages = josh_db_query("SELECT id FROM josh_pages WHERE content_dev <> content_live AND siteID = " . $_josh["site"]["id"]);
		while ($p = josh_db_fetch($pages)) josh_sys_discard($p["id"]);
		$redirect = "/j/draw_manage/";
	} elseif (josh_format_text_starts("draw_", $action)) {
		//trying to split these out into their libraries.  no need to return a redirect, since draw_action will self-terminate
		josh_draw_action($action, $id, $array, $parameter, $scroll);
	} elseif ($action == "email_not_found") {
		$message  = "the email you entered was not found&mdash;please try again. " . josh_format_link("contact " . strToLower($_josh["system"]["admin_name"]), "contact_admin") . ", the system administrator, if you are having trouble.<br><br>";
		$form = new josh_draw_table_form;
		$form->add_row("text", "email");
		$message .= $form->draw("forgot", "try again");
		echo josh_draw_page("email not found", $message, true);
	} elseif ($action == "email_sent") {
		echo josh_draw_page("check your email", "you were just sent a link to reset your password.");
	} elseif ($action == "forgot") {
		$message  = "enter the address you registered with below.  you will be sent a link so you can change your password.<br><br>";
		$form = new josh_draw_table_form;
		$form->add_row("text", "email");
		$message .= $form->draw("forgot_send", "send email");
		echo josh_draw_page("reset your password", $message);
	} elseif ($action == "forgot_send") {
		$user = josh_db_grab("SELECT josh_users.email, josh_users.key FROM josh_users WHERE josh_users.email = '{$array["email"]}'");
		if (isset($user["key"])) {
			josh_sys_email("joshserver <" . $_josh["system"]["admin_email"] . ">", $user["email"], josh_draw_page("change your password", "you can <a href='" . $_josh["site"]["full_url"] . "/j/password_change/" . $user["key"] . "/'>use this link</a> to change your joshserver password.", false, true), "change your joshserver password");
			$redirect   = "/j/email_sent/";
		} else {
			$redirect   = "j/email_not_found/";
		}
	} elseif ($action == "login") {
		$message  = "forgot your password?  you can " . josh_format_link("change it", "forgot") . "!  need a login?  " . josh_format_link("contact " . strToLower($_josh["system"]["admin_name"]), "contact_admin") . ", the system administrator.<br><br>";
		$form = new josh_draw_table_form;
		$form->add_row("text", "josh_email", @$_COOKIE["josh_email"]);
		$form->add_row("password", "josh_password");
		//if ($_josh["referrer"]["url"]) $form->add_hidden("hidden", "redirect", $_josh["referrer"]["url"]);
		$message .= $form->draw("login_exec", "welcome");
		echo josh_draw_page("welcome to joshserver", $message);
	} elseif ($action == "login_again") {
		$message  = "forgot your password?  you can " . josh_format_link("change it", "forgot") . "!  need a login?  " . josh_format_link("contact " . strToLower($_josh["system"]["admin_name"]), "contact_admin") . ", the system administrator.<br><br>";
		$form = new josh_draw_table_form;
		$form->add_row("text", "josh_email", @$_COOKIE["josh_email"]);
		$form->add_row("password", "josh_password");
		//todo - set hidden redirect field with caught pageID
		$message .= $form->draw("login_exec", "login again", true);
		echo josh_draw_page("please try again", $message, true);
	} elseif ($action == "login_exec") {
		$_josh["user"] = josh_db_grab("SELECT u.id, u.email, u.key FROM josh_users u WHERE u.email = '{$array["josh_email"]}' AND u.password = PASSWORD('{$array["josh_password"]}')");
		if (isset($_josh["user"]["key"])) {
			josh_sys_debug("good login");
			josh_db_query("UPDATE josh_users SET is_coding = 0 WHERE id = " . $_josh["user"]["id"]); //drawer ought to be closed when you log in
			josh_sys_tagbrowser($_josh["user"]["key"]);
		} else {
			josh_sys_debug("bad login");
			//todo - catch redirect pageID and pass to login_again
			$redirect = "/j/login_again/";
		}
	} elseif (($action == "logout") && $_josh["user"]) {
		$_josh["page"] = josh_sys_page($id, $parameter);
		josh_sys_tagbrowser();
		$redirect = $_josh["site"]["full_url"] . $_josh["page"]["url"];
	} elseif  ($action == "message_sent") {
		josh_draw_page("message sent", "your message was emailed to the system administrator.");
	} elseif  ($action == "switch") {
		$_josh["page"] = josh_sys_page($id, $parameter);
		$is_coding = ($_josh["user"]["is_coding"]) ? 0 : 1;
		josh_db_query("UPDATE josh_users SET is_coding = {$is_coding} WHERE id = " . $_josh["user"]["id"]);
		$redirect	= $_josh["page"]["url"];
	} elseif (josh_format_text_starts("object_", $action)) {
		//trying to split these out into their libraries.  starting with this one.
		$redirect = josh_object_action($action, $id, $array);
	} elseif (($action == "page_create") && $_josh["user"]) {
		if ($array["parentID"]) {
			$max = josh_db_grab("SELECT IFNULL((SELECT MAX(sequence) FROM josh_pages WHERE parentID = {$array["parentID"]}),  (SELECT sequence FROM josh_pages WHERE id = {$array["parentID"]})) sequence");
			$pages = josh_db_query("SELECT id, sequence FROM josh_pages WHERE sequence > {$max} AND siteID = " . $_josh["site"]["id"]);
			while ($p = josh_db_fetch($pages)) josh_db_query("UPDATE josh_pages SET sequence = " . ++$p["sequence"] . " WHERE id = " . $p["id"]);
		} else {
			$array["parentID"] = "NULL";
			$max = josh_db_grab("SELECT MAX(sequence) sequence FROM josh_pages WHERE siteID = " . $_josh["site"]["id"]);
		}
		josh_db_query("INSERT INTO josh_pages ( siteID, title, parentID, sequence, folder, created_on, created_by ) VALUES ( {$_josh["site"]["id"]}, '{$array["title"]}', {$array["parentID"]}, " . ++$max . ", '{$array["folder"]}', NOW(), {$_josh["user"]["id"]} )");
		$redirect   = "/" . $array["folder"] . "/";
	} elseif (($action == "page_delete") && $_josh["user"]) {
		$pages = josh_db_query("SELECT id, sequence FROM josh_pages WHERE sequence > (SELECT sequence FROM josh_pages WHERE id = {$id}) AND siteID = " . $_josh["site"]["id"]);
		while ($p = josh_db_fetch($pages)) josh_db_query("UPDATE josh_pages SET sequence = " . --$p["sequence"] . " WHERE id = " . $p["id"]);
		josh_db_query("DELETE FROM josh_pages WHERE id = " . $id);
		$redirect = "/j/draw_manage/";
	} elseif (($action == "page_move_down") && $_josh["user"]) {
		$sequence	= josh_db_grab("SELECT sequence FROM josh_pages WHERE id = " . $id);
		$onemore	= $sequence + 1;
		josh_db_query("UPDATE josh_pages SET sequence = {$sequence} WHERE sequence = {$onemore} AND siteID = " . $_josh["site"]["id"]);
		josh_db_query("UPDATE josh_pages SET sequence = {$onemore} WHERE id = " . $id);
		$redirect = "/j/draw_manage/";
	} elseif (($action == "page_move_left") && $_josh["user"]) {
		josh_db_query("UPDATE josh_pages SET parentID = NULL WHERE id = " . $id);
		$redirect = "/j/draw_manage/";
	} elseif ((($action == "page_lock") || ($action == "page_unlock")) && $_josh["user"]) {
		$is_private = ($action == "page_lock") ? 1 : 0;
		josh_db_query("UPDATE josh_pages SET is_private = {$is_private} WHERE id = " . $id);
		$redirect = "/j/draw_manage/";
	} elseif (($action == "page_move_right") && $_josh["user"]) {
		$_josh["page"] = josh_sys_page($id, $parameter);
		$parentID = josh_db_grab("SELECT id FROM josh_pages WHERE parentID IS NULL AND sequence < {$_josh["page"]["sequence"]} AND siteID = {$_josh["site"]["id"]} ORDER BY sequence DESC LIMIT 1");
		josh_db_query("UPDATE josh_pages SET parentID = {$parentID} WHERE id = " . $id);
		$redirect = "/j/draw_manage/";
	} elseif (($action == "page_move_up") && $_josh["user"]) {
		$sequence = josh_db_grab("SELECT sequence FROM josh_pages WHERE id = " . $id);
		$oneless = $sequence - 1;
		josh_db_query("UPDATE josh_pages SET sequence = {$sequence} WHERE sequence = {$oneless} AND siteID = " . $_josh["site"]["id"]);
		josh_db_query("UPDATE josh_pages SET sequence = {$oneless} WHERE id = " . $id);
		$redirect = "/j/draw_manage/";
	} elseif (($action == "page_update") && $_josh["user"]) {
		if ($array["editing"] == "page") {
			josh_db_query("UPDATE josh_pages SET content_dev = '{$array["original_code"]}', modified_on = NOW(), modified_by = {$_josh["user"]["id"]} WHERE id = " . $array["pageID"]);
		} else {
			josh_db_query("UPDATE josh_sites SET {$array["editing"]}_dev = '{$array["original_code"]}' WHERE id = " . $_josh["site"]["id"]);
		}
		if ($array["is_coding"] == 0) {
			josh_db_query("UPDATE josh_users SET is_coding = 0 WHERE id = " . $_josh["user"]["id"]);
			$_josh["page"] = josh_sys_page($array["pageID"], $array["parameter"]);
			$redirect = $_josh["page"]["url"];
		} else {
			$redirect = "/j/draw_view/" . $id_string . "/";
		}
	} elseif (($action == "page_update_title") && $_josh["user"]) {
		$_josh["page"] = josh_sys_page($id, $parameter);
		josh_db_query("UPDATE josh_pages SET title = '{$array["new_title"]}', num_updates = " . ($_josh["page"]["num_updates"] + 1) . " WHERE id = " . $array["pageID"]);
		$redirect = "/j/draw_view/" . $id_string . "/";
	} elseif  ($action == "password_change") {
		$userID = josh_db_grab("SELECT id FROM josh_users WHERE josh_users.key = '{$array["user"]}'");
		if ($userID) {
			$message  = "you can use this form to pick a new password.<br><br>";
			$form = new josh_draw_table_form;
			$form->add_hidden("userID", $userID);
			$form->add_row("password", "password");
			$form->add_row("password", "confirm");
			$message .= $form->draw("password_change_do", "change your password");
			josh_draw_page("change your password", $message);
		}
	} elseif ($action == "password_change_do") {
		josh_db_query("UPDATE josh_users SET josh_users.password = PASSWORD('{$array["password"]}') WHERE id = " . $array["userID"]);
		$key = josh_db_grab("SELECT u.key FROM josh_users u WHERE id = " . $array["userID"]);
		josh_sys_tagbrowser($key);
		$redirect = "/j/password_changed/";
	} elseif  ($action == "password_changed") {
		echo josh_draw_page("password changed", "ok!  your password has been changed.  you are already logged in.  <a href='/'>click here</a> to go to the home page.");
	} elseif ($action == "robots") {
		josh_sys_die(josh_draw_robots(), "txt");
	} elseif ($action == "rss") {
		josh_sys_die("checkcheck");
	} elseif (($action == "server_add") && $_josh["user"]) {
		josh_sys_site_delete();
		$siteID	= josh_db_query("INSERT INTO josh_sites ( url, www ) VALUES ( '{$_josh["request"]["sanswww"]}', {$_josh["request"]["usingwww"]} )");
		josh_db_query("INSERT INTO josh_users_to_sites ( userID, siteID, is_admin ) VALUES ( {$_josh["user"]["id"]}, {$siteID}, 1 )");
		if ($array["contenttype"] == "sample") {
			$xml = new josh_xml_import;
			$xml->parse("sample.xml");
			$xml->import($siteID);
		} elseif ($array["contenttype"] == "blank") {
			josh_db_query("INSERT INTO josh_pages ( siteID, title, sequence, folder, created_on, created_by ) VALUES ( {$siteID}, 'Blank Page', 1, NULL, NOW(), {$_josh["user"]["id"]} )");
		} elseif ($array["contenttype"] == "upload") {
			josh_xml_import($siteID);
		}
	} elseif (($action == "site_delete") && $_josh["user"]) {
		$message  = "clicking this button will delete " . $_josh["site"]["url"] . ".  you might want to " . josh_format_link("back up your content", "backup") . " first. there is no undoing this step.<br><br>";
		$form = new josh_draw_table_form;
		$message .= $form->draw("site_delete_do", "delete site");
		echo josh_draw_page("delete this site?", $message, true);
	} elseif (($action == "site_delete_do") && $_josh["user"]) {
		josh_db_query("DELETE FROM josh_users_to_sites WHERE siteID = " . $_josh["site"]["id"]);
		josh_sys_site_delete();
	} elseif (($action == "site_restore") && $_josh["user"]) {
		josh_db_query("DELETE FROM josh_pages WHERE siteID = " . $_josh["site"]["id"]);
		josh_xml_import($_josh["site"]["id"]);
	} elseif ($action == "sys_info") {
		$message  = "For information about this software, including downloads and documentation, please visit the " . josh_format_link("joshserver website", $_josh["website"], false, "josh_dark", true) . ".<br><br>";
		$message .= "<table cellpadding='3' cellspacing'2' border='0' class='josh_message' align='center'>";
		$message .= "<tr><td width='50%' align='right'>version</td><td width='50%'><b>" . $_josh["version"] . "</b></td></tr>";
		$message .= "<tr><td align='right'>administrator</td><td>" . josh_format_link(ucwords($_josh["system"]["admin_name"]), "contact_admin") . "</a></td></tr>";
		$message .= "<tr><td align='right'>installation date</td><td><b>" . josh_format_date($_josh["system"]["date_created"]) . "</b></td></tr>";
		$message .= "<tr><td align='right'>update date</td><td><b>" . josh_format_date($_josh["system"]["date_updated"]) . "</b></td></tr>";
		$message .= "<tr><td align='right'>updates</td><td><b>" . $_josh["system"]["updates_num"] . "</b></td></tr>";
		$message .= "<tr><td align='right'>users</td><td><b>" . $_josh["system"]["users_num"] . "</b></td></tr>";
		$message .= "<tr valign='top'><td align='right'>" . $_josh["system"]["sites_num"] . " sites</td><td>";
		$sites = josh_db_query("SELECT url, www FROM josh_sites ORDER BY url");
		while ($s = josh_db_fetch($sites)) {
			$url = ($s["www"]) ? "www." . $s["url"] : $s["url"];
			$message .= '<a href="http://' . $url . '/" class="josh_dark">' . $url . '</a><br/>';
		}
		$message .= "</td></tr>";
		$message .= "<tr><td align='right'>pages</td><td><b>" . $_josh["system"]["pages_num"] . "</b></td></tr>";
		$message .= "</table>";
		echo josh_draw_page("joshserver sys_info", $message);
	} elseif (($action == "tracking_code_update") && $_josh["user"]) {
		josh_db_query("UPDATE josh_sites SET tracking_code = '{$array["tracking_code"]}' WHERE id = " . $_josh["site"]["id"]);
		$redirect = "/j/draw_manage/";
	} elseif  ($action == "user_add_first") {
		$userID = josh_db_query("INSERT INTO josh_users ( josh_users.name, josh_users.email, josh_users.password, josh_users.key, josh_users.is_active ) VALUES ( '{$array["name"]}', '{$array["email"]}', PASSWORD('{$array["password"]}'), UUID(), 1 )");
		$key	= josh_db_grab("SELECT josh_users.key FROM josh_users WHERE id = " . $userID);
		josh_db_query("UPDATE josh_system SET userID = " . $userID);
		josh_sys_tagbrowser($key);
	} elseif ($action == "xml_sitemap") {
		josh_sys_die(josh_xml_sitemap(), "xml");
	}
	josh_sys_refresh($redirect);
}

function josh_sys_approve($id, $parameter=false) {
	global $_josh;
	$page = josh_sys_page($id, $parameter);
	josh_db_query("UPDATE josh_pages SET content_live = '" . josh_format_esc($page["content_dev"]) . "', approved_on = NOW(), approved_by = {$_josh["user"]["id"]}, num_updates = " . ($page["num_updates"] + 1) . " WHERE id = " . $page["id"]);
	josh_db_query("UPDATE josh_sites SET post_live = '" . josh_format_esc($_josh["site"]["post_dev"]) . "', css_live = '" . josh_format_esc($_josh["site"]["css_dev"]) . "', header_live = '" . josh_format_esc($_josh["site"]["header_dev"]) . "', footer_live = '" . josh_format_esc($_josh["site"]["footer_dev"]) . "' WHERE id = " . $_josh["site"]["id"]);
	return $page["url"];
}

function josh_sys_debug($message) {
	global $_josh;
	if ($_josh["debug"]) {
		echo $message . "<br/><hr noshade color='#cccccc' size='1'/>";
	}
}

function josh_sys_die($content, $type=false) {
	if ($type == "css") {
		header("Content-type: text/css;");
	} elseif ($type == "txt") {
		header("Content-type: text/plain;");
	} elseif ($type == "xml") {
		header("Content-type: text/plain; charset=UTF-8");
		header("Content-encoding: UTF-8");
	}
	echo $content;
	josh_db_close();
}

function josh_sys_discard($id, $parameter=false) {
	global $_josh;
	$page = josh_sys_page($id, $parameter);
	josh_db_query("UPDATE josh_pages SET content_dev = '" . josh_format_esc($page["content_live"]) . "', modified_on = NOW(), modified_by = {$_josh["user"]["id"]} WHERE id = " . $page["id"]);
	josh_db_query("UPDATE josh_sites SET post_dev = '" . josh_format_esc($_josh["site"]["post_live"]) . "', css_dev = '" . josh_format_esc($_josh["site"]["css_live"]) . "', header_dev = '" . josh_format_esc($_josh["site"]["header_live"]) . "', footer_dev = '" . josh_format_esc($_josh["site"]["footer_live"]) . "' WHERE id = " . $_josh["site"]["id"]);
	return $page["url"];
}

function josh_sys_email($from, $to, $message, $subject="Email from Your Website") {
	global $_josh;
	$headers  = "MIME-Version: 1.0" . $_josh["newline"];
	$headers .= "Content-type: text/html; charset=iso-8859-1" . $_josh["newline"];
	$headers .= "From: " . josh_format_email($from) . $_josh["newline"];
	if (!mail($to, $subject, $message, $headers)) {
		josh_draw_page("email failed", "sorry, an unexpected error occurred while sending your mail.", true);
		//this exits, so no need to return anything
	}
	return true;
}

function josh_sys_email_postdata($from, $to, $subject="Submission from Your Website") {
	global $_POST;
	josh_sys_email($from, $to, josh_draw_page($subject, josh_draw_array($_POST), false, true), $subject);
}

function josh_sys_file_get($filename) {
	return file_get_contents($filename); //todo: make php 4 compatible
	if (!$file = @fopen($filename, "r")) josh_sys_die("could not open file");
	$data = fread($file);
	fclose($file);
	return ($data);
}

function josh_sys_file_put($file_name, $content) {
	$file_pointer = fopen($file_name, "w");
	if ($file_pointer === false) {
		return false;
	} else {
		if (is_array($content)) $content = implode($content);
		$bytes_written = fwrite($file_pointer, $content);
		fclose($file_pointer);
		return $bytes_written;
	}
}

function josh_sys_page($id=false, $parameter=false) {
	josh_sys_debug("running josh_sys_page");
	global $_josh, $_GET;
	if ($id) {
		$return = josh_db_grab("SELECT p.id, p.parentID, p.folder, p.sequence, p.title, p.content_live, p.content_dev, 
						p.created_on, p.created_by, p.modified_on, p.modified_by, p.approved_on, approved_by, 
						num_updates, is_private,
						(SELECT p2.folder FROM josh_pages p2 WHERE p2.parentID = p.parentID AND p2.sequence = (p.sequence - 1)) folder_prev,
						(SELECT p2.folder FROM josh_pages p2 WHERE p2.parentID = p.parentID AND p2.sequence = (p.sequence + 1)) folder_next
						FROM josh_pages p 
						WHERE p.id = " . $id);
		if ($return["folder"]) {
			$return["url"] = "/" . $return["folder"] . "/";
		} else {
			$return["url"] = "/";
		}
		if ($parameter) {
			$return["parameter"] = $parameter;
			$return["url"] .= $parameter . "/";
		}
	} else {
		$folder = (isset($_GET["slot1"])) ? "= '" . $_GET["slot1"] . "'" : "IS NULL";
		josh_sys_debug("folder is " . $folder);
		$return = josh_db_grab("SELECT 
						p.id, 
						p.parentID, 
						p.folder, 
						p.sequence, 
						p.title, 
						p.content_live, p.content_dev, 
						p.created_on, p.created_by, 
						p.modified_on, p.modified_by, 
						p.approved_on, approved_by, 
						num_updates, is_private,
						(SELECT p2.folder FROM josh_pages p2 WHERE p2.parentID = p.parentID AND p2.sequence = (p.sequence - 1)) folder_prev,
						(SELECT p2.folder FROM josh_pages p2 WHERE p2.parentID = p.parentID AND p2.sequence = (p.sequence + 1)) folder_next
						FROM josh_pages p 
						WHERE p.folder " . $folder . " AND p.siteID = " . $_josh["site"]["id"]);
		$return["slot1"] = (isset($_GET["slot1"])) ? $_GET["slot1"] : false;
		$return["slot2"] = (isset($_GET["slot2"])) ? $_GET["slot2"] : false;
		$return["slot3"] = (isset($_GET["slot3"])) ? $_GET["slot3"] : false;
		if (!$return["slot1"]) {
			$return["url"] = "/";
		} elseif ($return["slot2"]) {
			$return["url"] = $return["url"] = "/" . $return["slot1"] . "/" . $return["slot2"] . "/";
		} else {
			$return["url"] = $return["url"] = "/" . $return["slot1"] . "/";
		}
	}
	if (isset($return["id"]))  {
		josh_sys_debug("page found");
		$return["unapproved_content"] = (($return["content_live"] != $return["content_dev"]) || ($_josh["site"]["post_live"] != $_josh["site"]["post_dev"]) || ($_josh["site"]["css_live"] != $_josh["site"]["css_dev"]) || ($_josh["site"]["header_live"] != $_josh["site"]["header_dev"]) || ($_josh["site"]["footer_live"] != $_josh["site"]["footer_dev"])) ? true : false;
		$return["url_prev"] = "/" . $return["folder_prev"] . "/";
		$return["url_next"] = "/" . $return["folder_next"] . "/";
		return $return;
	} else {
		josh_sys_debug("no page found");
		return false;
	}
}

function josh_sys_page_next($id=false) {
	global $_josh;
	if ($id) $_josh["page"] = josh_sys_page($id);
	//$return = josh_db_query("SELECT folder
}

function josh_sys_proctime() {
	global $_josh;
	return round(microtime(true) - $_josh["time_start"], 2) . " seconds";
}

function josh_sys_querystring_parse($querystring) {
	$pairs = explode("&", $querystring);
	$return = array();
	foreach ($pairs as $pair) {
		list($key, $value) = explode("=", $pair);
		$return[$key] = urldecode($value);
	}
	return $return;
}

function josh_sys_refresh($redirect=false) {
	global $_josh, $_POST;
	if ($redirect === false) { //if redirect is really set to FALSE, send to site home
		$redirect = "/";
	} elseif (!$redirect) { //if redirect is an empty string, refresh the page by sending back to same URL
		$redirect = (isset($_josh["page"]["folder"])) ? "/" . $_josh["page"]["folder"] . "/" : $_josh["request"]["path_query"];
		if (!empty($_josh["page"]["slot2"])) $redirect .= $_josh["page"]["slot2"] . "/";
		if (!empty($_POST["querystring"])) $redirect .= "?" . $_POST["querystring"];
	}
	if ($_josh["slow"]) {
		josh_sys_debug("<b>josh_sys_redirect</b> (slow) to " . $redirect);
		if ($_josh["debug"]) josh_db_close();
		echo "<html><head>
				<script language='javascript'>
					<!--
					location.href='" . $redirect . "';
					//-->
				</script>
			</head><body></body></html>";
	} else {
		josh_sys_debug("<b>josh_sys_redirect</b> (fast) to " . $redirect);
		if ($_josh["debug"]) josh_db_close();
		header("Location: " . $redirect);
	}
	josh_db_close();
}

function josh_sys_site_delete() {
	global $_josh;
	if (isset($_josh["site"]["id"])) {
		josh_db_query("DELETE FROM josh_pages WHERE siteID = " . $_josh["site"]["id"]);
		josh_db_query("DELETE FROM josh_sites WHERE id     = " . $_josh["site"]["id"]);
	}
}

function josh_sys_tagbrowser($key="") {
	global $_josh;
	$time = (empty($key)) ? time()-3600 : mktime(0, 0, 0, 1, 1, 2030);
	josh_sys_debug("<b>josh_sys_tagbrowser</b> with " . $key);
	if (!$_josh["debug"]) setcookie("josh_key", $key, $time, "/", "." . $_josh["request"]["domain"]);
	$_COOKIE["josh_key"] = $key;
	if (!empty($key)) {
		if (!$_josh["debug"]) setcookie("josh_email", $_josh["user"]["email"], $time, "/", "." . $_josh["request"]["domain"]);
		$_COOKIE["josh_email"] = $_josh["user"]["email"];
	}
	$_josh["slow"] = true;
}

function josh_sys_url_parse($url) {
	$gtlds = explode(',', str_replace(' ', '', "aero, biz, com, coop, info,
	jobs, museum, name, net, org, pro, travel, gov, edu, mil, int, site"));

	$ctlds = explode(',', str_replace(' ', '', "ac, ad, ae, af, ag, ai, al,
	am, an, ao, aq, ar, as, at, au, aw, az, ax, ba, bb, bd, be, bf, bg, bh,
	bi, bj, bm, bn, bo, br, bs, bt, bv, bw, by, bz, ca, cc, cd, cf, cg, ch,
	ci, ck, cl, cm, cn, co, cr, cs, cu, cv, cx, cy, cz, de, dj, dk, dm, do,
	dz, ec, ee, eg, eh, er, es, et, eu, fi, fj, fk, fm, fo, fr, ga, gb, gd,
	ge, gf, gg, gh, gi, gl, gm, gn, gp, gq, gr, gs, gt, gu, gw, gy, hk, hm,
	hn, hr, ht, hu, id, ie, il, im, in, io, iq, ir, is, it, je, jm, jo, jp,
	ke, kg, kh, ki, km, kn, kp, kr, kw, ky, kz, la, lb, lc, li, lk, lr, ls,
	lt, lu, lv, ly, ma, mc, md, mg, mh, mk, ml, mm, mn, mo, mp, mq, mr, ms,
	mt, mu, mv, mw, mx, my, mz, na, nc, ne, nf, ng, ni, nl, no, np, nr, nu,
	nz, om, pa, pe, pf, pg, ph, pk, pl, pm, pn, pr, ps, pt, pw, py, qa, re,
	ro, ru, rw, sa, sb, sc, sd, se, sg, sh, si, sj, sk, sl, sm, sn, so, sr,
	st, sv, sy, sz, tc, td, tf, tg, th, tj, tk, tl, tm, tn, to, tp, tr, tt,
	tv, tw, tz, ua, ug, uk, um, us, uy, uz, va, vc, ve, vg, vi, vn, vu, wf,
	ws, ye, yt, yu, za, zm, zw"));

	//todo: add support for https
	if (!strstr($url, 'http://')) $url = "http://" . $url; 
	
	$subs			= ''; 
	$domainname		= ''; 
	$tld			= ''; 
	$tldarray		= array_merge($gtlds, $ctlds); 
	$tld_isReady	= false;
	$return			= parse_url(trim($url));
	$domainarray	= explode('.', $return["host"]);
	$top			= count($domainarray);
	
	for ($i = 0; $i < $top; $i++) {
		$_domainPart = array_pop($domainarray);
		if (!$tld_isReady) {
			if (in_array($_domainPart, $tldarray)) {
				$tld = ".$_domainPart" . $tld;
			} else {
				$domainname = $_domainPart;
				$tld_isReady = 1;
			}
		} else {
			$subs = ".$_domainPart" . $subs;
		}
	}
	
	$return["path_query"]	= (isset($return["query"])) ? $return["path"] . "?" . $return["query"] : $return["path"];
	$return["uri"]			= $return["scheme"] . "://" . $return["host"] . $return["path_query"];
	$return["domain"]		= $domainname . $tld;
	$return["usingwww"]		= (substr($return["host"], 0, 4) == "www.") ? 1 : 0;
	$return["sanswww"]		= ($return["usingwww"]) ? substr($return["host"], 4) : $return["host"];
	$return["subdomain"]	= substr($subs, 1);
	ksort($return);
	return $return;
}

?>