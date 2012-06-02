<?php
/* welcome to joshserver!  you can find out more info about this product and
download the latest version at http://server.joshreisner.com/ */

error_reporting(E_ALL);

//parse environment variables
	$_josh["server"]["host"]	= $_SERVER["HTTP_HOST"];
	//$_josh["server"]["isunix"]	= strstr($_SERVER["SERVER_SOFTWARE"], "Unix");
	$_josh["server"]["mobile"]	= strstr($_SERVER["HTTP_USER_AGENT"], "iPhone");
	$_josh["server"]["isunix"]	= true; //todo: can't find in ICD -- more research required
	$_josh["server"]["refer"]	= (isset($_SERVER["HTTP_REFERER"])) ? $_SERVER["HTTP_REFERER"] : false;
	$_josh["server"]["request"]	= $_SERVER["REQUEST_URI"];

//set variables
	$_josh["time_start"]		= microtime(true);	//count processing time -- use josh_sys_proctime() to access this in a page
	$_josh["today"]				= date("j");		//useful date info.  todo -- combine these into an array
	$_josh["year"]				= date("Y");
	$_josh["month"]				= date("m");
	$_josh["colors"]			= array(	//all the colors of the joshserver rainbow
									"white"	=>"#ffffff",
									"grey1"	=>"#f0f0f0",
									"grey2"	=>"#e6e6e6", 
									"grey3"	=>"#cccccc",
									"grey4" =>"#aaaaaa",
									"grey5"	=>"#777777",
									"red1"	=>"#cc9999",
									"red2"	=>"#cc5555",
									"yellow"=>"#ffffcc"
									);
	$_josh["config"]			= "../../private/joshserver.txt"; //location of config file.  for security reasons, should be below the wwwroot
	$_josh["context"]			= "server";	//set to 'server' for form actions by joshserver, 'user' for user form processing
	$_josh["debug"]				= false;	//debug mode, displays what's going on
	$_josh["drawn"]["css"]		= false;	//only run josh_draw_css() once
	$_josh["drawn"]["js"]		= false;	//only run josh_draw_javascript() once
	$_josh["drawn"]["focus"]	= false;	//only autofocus on one form
	$_josh["forms"]				= array();	//for handling multiple forms in a page (eg which one gets autofocus?)
	$_josh["ignored_words"]		= array("1","2","3","4","5","6","7","8","9","0","about","after","all","also","an","and","another","any","are",
									"as","at","be","because","been","before","being","between","both","but","by","came","can","come",
									"could","did","do","does","each","else","for","from","get","got","has","had","he","have","her","here",
									"him","himself","his","how","if","in","into","is","it","its","just","like","make","many","me","might",
									"more","most","much","must","my","never","now","of","on","only","or","other","our","out","over","re",
									"said","same","see","should","since","so","some","still","such","take","than","that","the","their",
									"them","then","there","these","they","this","those","through","to","too","under","up","use","very",
									"want","was","way","we","well","were","what","when","where","which","while","who","will","with",
									"would","you","your","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s",
									"t","u","v","w","x","y","z",""); //ignore these words when making search indexes
	$_josh["mode"]				= "live"; //this could be changed later -- see line 76
	$_josh["months"]			= array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
	$_josh["libraries"]			= array("db", "draw", "format", "object", "sys", "xml");
	$_josh["newline"]			= ($_josh["server"]["isunix"]) ? "\n" : "\r\n";
	$_josh["numbers"]			= array("zero","one","two","three","four","five","six","seven","eight","nine");
	$_josh["queries"]			= array();	//for counting trips to the database
	$_josh["slow"]				= false;	//use javascript redirects when setting cookies; they don't work using faster 'header' redirects
	$_josh["user_key"]			= (isset($_COOKIE["josh_key"])) ? $_COOKIE["josh_key"] : false;
	$_josh["version"]			= 5;		//track software revision number
	$_josh["website"]			= "server.joshreisner.com"; // info, downloads and more.  this address might change.

//gather includes
	foreach ($_josh["libraries"] as $library) require("joshserver/" . $library . ".php");
	
//connect to db, make sure it is up and populated
	$_josh["db"]				= josh_db_connect();
	$_josh["system"]			= josh_db_check();
	
//find out about environment (you can use josh_draw_array($array, false) to display these arrays for debugging -- see line 75 below)
	$_josh["request"]			= josh_sys_url_parse("http://" . $_josh["server"]["host"] . $_josh["server"]["request"]);
	$_josh["referrer"]			= ($_josh["server"]["refer"]) ? josh_sys_url_parse($_josh["server"]["refer"]) : false;
	if ($_josh["referrer"] && isset($_josh["referrer"]["query"])) {
		//die("hi"); ~ todo: fix referrer situation
		$_josh["referrer"]["query_array"] = josh_sys_querystring_parse($_josh["referrer"]["query"]);
		if (isset($_josh["referrer"]["query_array"]["pageID"])) {
			//when would this happen?
			$_josh["referrer"] = josh_db_grab("SELECT p.id, p.url, p.sequence, p.title, p.content_live, p.content_dev, p.created_on, p.created_by, p.modified_on, p.modified_by, p.approved_on, approved_by, num_updates, is_private FROM josh_pages p WHERE p.id = " . $_josh["referrer"]["query_array"]["pageID"]);
		}
	}

//find out about site	
	$_josh["site"]				= josh_db_grab("SELECT
											s.id, s.url, s.www, s.post_live, s.post_dev, s.css_live, s.css_dev, 
											s.header_live, s.header_dev, s.footer_live, s.footer_dev, 
											s.tracking_code, s.content_width,
											(SELECT COUNT(*) FROM josh_pages p WHERE p.siteID = s.id) count_pages,
											(SELECT COUNT(*) FROM josh_pages p WHERE p.siteID = s.id AND p.content_dev <> p.content_live) pages_pending
											FROM josh_sites s WHERE s.url = '{$_josh["request"]["sanswww"]}'");
	$_josh["site"]["full_url"]	= "http://" . ((@$_josh["site"]["www"]) ? "www." : "") . @$_josh["site"]["url"];
	if (isset($_josh["site"]["id"])) {
		//find out about user
		$_josh["user"]				= ($_josh["user_key"]) ? josh_db_grab("SELECT u.id, u.name, u.email, u.is_coding, u2s.is_admin FROM josh_users u JOIN josh_users_to_sites u2s ON u.id = u2s.userID WHERE u2s.siteID = {$_josh["site"]["id"]} AND u.key = '{$_COOKIE["josh_key"]}' AND u.is_active = 1") : false;
		if ($_josh["user"]) {
			$_josh["user"]["drawer_size"] = 300; //todo -- make this settable by dragging frameset around
			josh_db_query("UPDATE josh_users SET last_active = NOW() WHERE id = " . $_josh["user"]["id"]);
		}
		if ($_josh["user"]["is_admin"]) $_josh["mode"] = "dev";
	} else {
		//find out about user without asking relationship to site bc site's not created yet
		$_josh["user"]				= ($_josh["user_key"]) ? josh_db_grab("SELECT u.id, u.name, u.email, u.is_coding FROM josh_users u WHERE u.key = '{$_COOKIE["josh_key"]}' AND u.is_active = 1") : false;
	}

//run main display logic
	if ($_POST) { //first check if there is POSTing.  this will be handled & redirected. it precedes everything else
		josh_sys_debug("posting");
		foreach($_POST as $key => $value) $_POST[$key] = josh_format_esc($value);
		if (isset($_POST["j"])) { //could be a joshserver POST action
			josh_sys_action($_POST["j"], false, $_POST);
		} else { //or could be a user POST action
			josh_draw_eval_post($_josh["mode"]);
		}
	} elseif (!$_josh["system"]["users_num"]) { //users not yet set up, this is the first installation step (second step overall)
		josh_sys_debug("users not set up");
		josh_sys_tagbrowser();
		if ($_josh["request"]["path_query"] != "/") josh_sys_refresh(); //we shouldn't be seeing path or query at this stage
		$message  = "the first step is to create your user account.  this account will automatically get administrative privileges. all these fields are required.  also, ensure that your browser accepts cookies.  otherwise, you can't move on to the next step.<br><br>";
		$form = new josh_draw_table_form;
		$form->add_row("text", "name", false, "your name");
		$form->add_row("text", "email");
		$form->add_row("password", "password");
		$form->add_row("password", "confirm");
		$message .= $form->draw("user_add_first", "welcome");
		echo josh_draw_page("welcome to joshserver", $message);
	} elseif ((empty($_josh["site"]["id"]) || empty($_josh["site"]["count_pages"])) && @$_GET["slot1"] != "j") { //current site not yet set up, the second installation step
		josh_sys_debug("current site not set up");
		if ($_josh["user"]) {
			$message  = "is the URL below what you want to use for your site, (ie would you prefer it with our without the www)?  to make a change, just change the location in your browser.<br><br>";
			$form = new josh_draw_table_form;
			$form->add_row("raw", "address", "<b>" . $_josh["request"]["host"] . "</b>");
			$form->add_row("raw", "start with", "<table cellpadding='1' cellspacing='0' border='0' class='josh_message'>
								<tr>
									<td><input type='radio' name='contenttype' value='sample' checked></td>
									<td><div style='cursor:default;' onclick='javascript:document.configureserver.contenttype[1].checked=true;document.configureserver.contenttype[0].checked=false;document.configureserver.contenttype[2].checked=false;' >a prefab example site</div></td>
								</tr>
								<tr>
									<td width='10'><input type='radio' name='contenttype' value='blank'></td>
									<td><div style='cursor:default;' onclick='javascript:document.configureserver.contenttype[1].checked=false;document.configureserver.contenttype[0].checked=true;document.configureserver.contenttype[2].checked=false;'>a blank page</div></td>
								</tr>
								<tr>
									<td><input type='radio' name='contenttype' value='upload'></td>
									<td><div style='cursor:default;' onclick='javascript:document.configureserver.contenttype[1].checked=false;document.configureserver.contenttype[0].checked=false;document.configureserver.contenttype[2].checked=true;' >a " . josh_format_link("joshserver XML file", $_josh["website"] . "documentation/schemas/", false, "josh_dark", true) . "</div></td>
								</tr>
							</table>");
			$form->add_row("file", "file");
			$message .= $form->draw("server_add", "configure");
			echo josh_draw_page("initialize this server", $message);
		} else {
			echo josh_draw_page("website coming soon", "the administrator has not yet configured a site here.  if you are the admin, you may log in " . josh_format_link("here", "login") . ".", true);
		}
	} elseif (isset($_josh["site"]["id"]) && ($_josh["request"]["usingwww"] != $_josh["site"]["www"])) { //fix www in the url
		josh_sys_debug("fixing www in url");
		josh_sys_refresh($_josh["site"]["full_url"] . $_josh["request"]["path_query"]);
	} elseif (@$_GET["slot1"] == "j") { //there's a GET action, pass to switchboard
		josh_sys_debug("handling GET");
		josh_sys_action(@$_GET["slot2"], @$_GET["slot3"]);
	} elseif (!$_josh["page"] = josh_sys_page()) { //page not yet configured, display a 404
		josh_sys_debug("404");
		if ($_josh["user"]) { //display administrative 'add a page' option
			josh_sys_debug("and user logged in");
			$message	= "there's no page at this address.  do you want to create one?<br><br>";
			$folder		= str_replace("/", "", $_josh["request"]["path"]);
			$url		= "/" . $folder . "/";
			josh_sys_debug("url is " . $url);
			if (($url != "//") && ($_josh["request"]["path_query"] != $url)) josh_sys_refresh($url);
			$form = new josh_draw_table_form;
			$form->add_row("raw",    "address", "<b>" . $url . "</b>");
			$form->add_row("text",   "title", josh_format_text_human($folder));
			$form->add_row("select", "parentID", false, "belongs to", "SELECT id, title FROM josh_pages WHERE parentID IS NULL AND siteID = {$_josh["site"]["id"]} ORDER BY sequence", true, false);
			$form->add_hidden("folder", $folder);
			$message .= $form->draw("page_create", "create page");
		} else { //show public error message
			josh_sys_debug("and user not logged in");
			$message  = "there is no page at this address.  if you feel you reached this page in error, please " . josh_format_link("contact " . strToLower($_josh["system"]["admin_name"]), "contact_admin") . ", the system administrator.<br><br>if you are a member, please " . josh_format_link("log in", "login") . ".";
			//todo - email administrator that a link is broken?  check referrer?
		}
		echo josh_draw_page("page not found", $message, true);
	} elseif (@$_josh["page"]["is_private"] && !$_josh["user"]) { //page is secure and user doesn't have access
		josh_sys_debug("page is secure, user doesn't have access");
		$message  = "the page you are trying to view is limited to authorized users only.  forgot your password?  you can " . josh_format_link("change it", "forgot") . "!  need a login?  " . josh_format_link("contact " . strToLower($_josh["system"]["admin_name"]), "contact_admin") . ", the system administrator.<br><br>";
		$form = new josh_draw_table_form;
		$form->add_hidden("pageID", $_josh["page"]["id"]);
		$form->add_row("text", "josh_email", @$_COOKIE["josh_email"]);
		$form->add_row("password", "josh_password");
		$message .= $form->draw("login_exec", "welcome");
		echo josh_draw_page("please log in", $message, true);
	} elseif ($_josh["user"]["is_admin"]) { //user is logged in & has admin permissions, display administrative frameset
		josh_sys_debug("admin frameset");
		//if (isset($_josh["referrer"]["id"])) die("yo");
		$id_string = ($_josh["page"]["slot2"]) ? $_josh["page"]["id"] . "_" . $_josh["page"]["slot2"] : $_josh["page"]["id"];
		?><html>
			<head>
				<title><?php echo $_josh["page"]["title"]?></title>
				<script language="javascript">
					<!--
					function josh_title(current_title) {
						var reply = prompt("retitle this page", current_title);
						if (reply) {
							josh_bottom.document.titleform.new_title.value = reply;
							josh_bottom.document.titleform.submit();
							document.title = reply;
						}
					}
					//-->
				</script>
			</head>
			<?php if ($_josh["user"]["is_coding"]) {?>
			<frameset rows="*,<?php echo $_josh["user"]["drawer_size"];?>" frameborder="0">
				<frame src="/j/draw_view/<?php echo $id_string;?>/" name="josh_view">
				<frame src="/j/draw_code_page/<?php echo $id_string;?>/" name="josh_bottom" noresize scrolling="no">
			<?php } else {?>
			<frameset rows="*,26" frameborder="0">
				<frame src="/j/draw_view/<?php echo $id_string;?>/" name="josh_view">
				<frame src="/j/draw_buttons/<?php echo $id_string;?>/" name="josh_bottom" noresize scrolling="no">
			<?php }?>
			</frameset>
		</html><?php
	} else { //user not logged in, display public content
		josh_draw_eval($_josh["mode"]);
	}
	
//close
	josh_db_close();
?>