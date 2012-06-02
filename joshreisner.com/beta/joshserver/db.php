<?php
//database functions

function josh_db_check() {
	global $_josh;
	if ($result = josh_db_grab("SELECT s.version, s.date_created, s.date_updated, s.updates_num, u.name admin_name, u.email admin_email, (SELECT count(*) FROM `josh_users`) users_num, (SELECT count(*) FROM `josh_sites`) sites_num, (SELECT count(*) FROM `josh_pages`) pages_num FROM `josh_system` s LEFT JOIN josh_users u ON s.userID = u.id", true)) {
		if ($result["version"] != $_josh["version"]) { //joshserver files have just been updated
			josh_db_query("UPDATE josh_system SET version = {$_josh["version"]}, date_updated = NOW(), updates_num = " . ++$result["updates_num"]);
			return josh_db_check();
		}
		return $result;
	} else { //db tables aren't there yet, so create them
		josh_db_query("CREATE TABLE `josh_system`			( `version` int(11) NOT NULL, `date_created` datetime default NULL, `date_updated` datetime default NULL, `updates_num` int(11) default NULL, `userID` int(11) default NULL ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
		josh_db_query("INSERT INTO  `josh_system`			( version, date_created, updates_num ) VALUES ({$_josh["version"]}, NOW(), 0)");
		josh_db_query("CREATE TABLE `josh_sites`			( `id` int(11) NOT NULL auto_increment, `url` varchar(255) NOT NULL default '', `www` tinyint(1) NOT NULL default 0, `tracking_code` varchar(255) default NULL, `content_width` int(11) NULL, `post_live` text NOT NULL default '', `post_dev` text NOT NULL default '', `css_live` text NOT NULL default '', `css_dev` text NOT NULL default '', `header_live` text NOT NULL default '', `header_dev` text NOT NULL default '', `footer_live` text NOT NULL default '', `footer_dev` text NOT NULL default '', PRIMARY KEY  (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
		josh_db_query("CREATE TABLE `josh_users`			( `id` int(11) NOT NULL auto_increment, `name` varchar(255) NOT NULL default '', `email` varchar(255) NOT NULL default '', `password` varbinary(41) NOT NULL default '', `key` varchar(36) NOT NULL default '', `is_active` tinyint(1) NOT NULL DEFAULT 1, `is_coding` tinyint(1) NOT NULL DEFAULT 0, `last_active` datetime default NULL, `content_width` int(11) default NULL, PRIMARY KEY  (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
		josh_db_query("CREATE TABLE `josh_users_to_sites`	( `userID` int(11) NOT NULL, `siteID` int(11) NOT NULL, `is_admin` tinyint(0) NOT NULL DEFAULT 1, KEY `userID` (`userID`), KEY `siteID` (`siteID`) ) ENGINE=MyISAM DEFAULT CHARSET=latin1;");
		josh_db_query("CREATE TABLE `josh_pages`			( `id` int(11) NOT NULL auto_increment, `siteID` int(11) NOT NULL, `parentID` int(11) default NULL, `folder` varchar(255) default NULL, `title` varchar(255) NOT NULL default '', `sequence` int(11) NOT NULL, `content_live` text NOT NULL default '', `content_dev` text NOT NULL default '', `created_on` datetime default NULL, `created_by` int(11) NOT NULL default '0', `modified_on` datetime default NULL, `modified_by` int(11) default NULL, `approved_on` datetime default NULL, `approved_by` int(11) default NULL, `num_updates` int(11) default 1, `is_private` tinyint(1) NOT NULL default 0, PRIMARY KEY  (`id`), KEY `siteID` (`siteID`), CONSTRAINT `josh_pages_ibfk_1` FOREIGN KEY (`siteID`) REFERENCES `josh_sites` (`id`) ON UPDATE NO ACTION ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

		//objects
		josh_db_query("CREATE TABLE `josh_objects_types`	( `id` int(11) NOT NULL auto_increment, `name_singular` varchar(255) NOT NULL default '', `name_plural` varchar(255) NOT NULL default '', `created_by` int(11) NOT NULL default '0', `is_private` tinyint(4) NOT NULL default '0', `is_active` tinyint(4) NOT NULL default '1', PRIMARY KEY  (`id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
		josh_db_query("CREATE TABLE `josh_objects_types_to_sites` ( `object_typeID` int(11) NOT NULL default '0', `siteID` int(11) NOT NULL default '0') ENGINE=InnoDB DEFAULT CHARSET=latin1;");
		josh_db_query("CREATE TABLE `josh_objects`			( `id` int(11) NOT NULL auto_increment, `typeID` int(11) NOT NULL default '0', `firstInstanceID` int(11) NOT NULL default '0', `currentInstanceID` int(11) default NULL, `deleted_on` datetime default NULL, `deleted_by` int(11) default NULL, `is_active` tinyint(4) NOT NULL default '0', `key` varchar(13) NOT NULL default '', PRIMARY KEY  (`id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
		josh_db_query("CREATE TABLE `josh_fields`			( `id` int(11) NOT NULL auto_increment, `typeID` int(11) NOT NULL default '0', `object_typeID` int(11) NOT NULL default '0', `flag_typeID` int(11) default NULL, `display_name` varchar(255) NOT NULL default '', `column_name` varchar(255) NOT NULL default '', `is_required` tinyint(4) NOT NULL default '0', `is_admin` tinyint(4) NOT NULL default '0', `precedence` int(11) NOT NULL default '0', PRIMARY KEY  (`id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
		josh_db_query("CREATE TABLE `josh_fields_types`		( `id` int(11) NOT NULL, `name` varchar(255) NOT NULL default '', `type` varchar(255) NOT NULL default '', PRIMARY KEY  (`id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
		josh_db_query("INSERT INTO	`josh_fields_types`		VALUES
			( 1,'Text - Short','varchar'),
			( 2,'Text - Long','text'),
			( 3,'Date & Time','datetime'),
			( 4,'Flag - Multiple','flag_multiple'),
			( 5,'Flag - Single','flag_single'),
			( 6,'Money','decimal'),
			( 7,'Integer','int'),
			( 8,'Date','datetime'),
			( 9,'URL','text'),
			(10,'Text - Rich','text'),
			(11,'Flag - Single (Radio)','flag_single');");
		josh_db_query("CREATE TABLE `josh_flags`			( `id` int(11) NOT NULL auto_increment, `typeID` int(11) NOT NULL default '0', `name` varchar(255) NOT NULL default '', `precedence` int(11) NOT NULL default '0', `is_active` tinyint(1) NOT NULL default '0', PRIMARY KEY  (`id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
		josh_db_query("CREATE TABLE `josh_flags_types`		( `id` int(11) NOT NULL auto_increment, `name` varchar(255) NOT NULL default '', `defaultID` int(11) NOT NULL default '0', PRIMARY KEY  (`id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
		josh_db_query("CREATE TABLE `josh_instances`		( `id` int(11) NOT NULL auto_increment, `objectID` int(11) NOT NULL default '0', `varchar_1` varchar(255) default NULL, `varchar_2` varchar(255) default NULL, `varchar_3` varchar(255) default NULL, `text_1` text, `text_2` text, `text_3` text, `datetime_1` datetime default NULL, `datetime_2` datetime default NULL, `datetime_3` datetime default NULL, `money_1` decimal(10,0) default NULL, `money_2` decimal(10,0) default NULL, `money_3` decimal(10,0) default NULL, `int_1` int(11) default NULL, `int_2` int(11) default NULL, `int_3` int(11) default NULL, `created_on` datetime NOT NULL default '0000-00-00 00:00:00', `created_by` int(11) NOT NULL default '0', PRIMARY KEY  (`id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
		josh_db_query("CREATE TABLE `josh_instances_to_flags` ( `instanceID` int(11) NOT NULL default '0', `flagID` int(11) NOT NULL default '0') ENGINE=InnoDB DEFAULT CHARSET=latin1;");
		josh_db_query("CREATE TABLE `josh_instances_to_words` ( `instanceID` int(11) NOT NULL default '0', `wordID` int(11) NOT NULL default '0', `occurrences` int(11) NOT NULL default '0') ENGINE=InnoDB DEFAULT CHARSET=latin1;");
		josh_db_query("CREATE TABLE `josh_words`			( `id` int(11) NOT NULL auto_increment, `word` varchar(255) NOT NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
		return josh_db_check();
	}
}

function josh_db_clear($string) {
	//cant find where this is called from.  obsolete?
	$tables = explode(",", $string);
	foreach ($tables as $table) josh_db_query("DELETE FROM " . $table);
}

function josh_db_close() {
	//close connection and quit
	global $_josh;
	@mysql_close($_josh["db_pointer"]);
	//echo "<br><br>here are all the db queries:<hr>" . implode("<hr>", $_josh["queries"]);
	exit;
}

function josh_db_connect() {
	global $_josh;

	/*
	$_josh["db"]["location"] = "localhost:/tmp/mysql5.sock";
	$_josh["db"]["database"] = "joshreisner_joshserver";
	$_josh["db"]["username"] = "joshreisner";
	$_josh["db"]["password"] = "coterie";
	die(serialize($_josh["db"]));
	
	$_josh["db"]["location"] = "localhost";
	$_josh["db"]["database"] = "joshserver";
	$_josh["db"]["username"] = "joshserver";
	$_josh["db"]["password"] = "sbagliato";
	die(serialize($_josh["db"]));
	*/
	
	//get db config file
	
	if (!$return = unserialize(josh_sys_file_get($_josh["config"]))) {
		if (@touch($filename)) {
			$return["location"] = "localhost:/tmp/mysql5.sock";
			$return["database"] = "joshserver";
			$return["username"] = "";
			$return["password"] = "";
			josh_sys_file_put($_josh["config"], serialize($return));
			return josh_db_connect();
		} else {
			echo josh_draw_page("file permission problem", "joshserver couldn't write to <span class='josh_code'>" . $_josh["config"] . "</span>.  please create a file there and give it group-writable permissions.", true);
		}
	}

	//connect to db
	if ($return["pointer"] = @mysql_connect($return["location"], $return["username"], $return["password"])) {
		if (@mysql_select_db($return["database"], $return["pointer"])) return $return;
	}
	josh_draw_page("database connection error", "joshserver could not connect to the database with the credentials you specified.  please supply valid credentials.  if these are correct, it's also possible that the database server is down.", true);
}

function josh_db_fetch($result) {
	return mysql_fetch_array($result);
}

function josh_db_found($result) {
	return @mysql_num_rows($result);
}

function josh_db_grab($query, $checking=false) {
	$result = josh_db_query($query, $checking);
	if (!josh_db_found($result)) {
		return false;
	} else {
		$r = josh_db_fetch($result);
		if (count($r) == 2) $r = $r[0]; //if returning just one value, make it scalar
		return $r;
	}
}

function josh_db_id() {
	return mysql_insert_id();
}

function josh_db_query($query, $suppress_error=false) {
	global $_josh;
	$_josh["queries"][] = $query;
	josh_sys_debug("<b>josh_db_query</b> <i>" . $query . "</i>");
	if ($result = mysql_query($query, $_josh["db"]["pointer"])) {
		if (strToLower(substr($query, 0, 6)) == "insert") return josh_db_id();
		return $result;
	} else {
		if ($suppress_error) return false;
		$_josh["drawn"]["css"] = false; //have to make sure this is false bc we could have been in the process of drawing a page (such as draw_manage, say)
		$back = debug_backtrace();
		josh_draw_page("mysql syntax error", josh_format_code($query) . "<br><br>" . mysql_error() . " on line " . $back[0]["line"] . " of file " . $back[0]["file"], true);
	}
}
?>