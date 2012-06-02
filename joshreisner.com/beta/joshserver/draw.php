<?php
//draw functions

function josh_draw_action($action, $id=false, $array=false, $parameter=false, $scroll=false) {
	global $_josh;
	if ((($action == "draw_buttons") || (josh_format_text_starts("draw_code_", $action))) && $_josh["user"]) { //bottom frame
		$id_string = ($parameter) ? $id . "_" . $parameter : $id;
		$_josh["page"]  = josh_sys_page($id);
		if (josh_format_text_starts("draw_code_", $action)) {
			$editing		= str_replace("draw_code_", "", $action);
			$code			= ($editing == "page") ? $_josh["page"]["content_dev"] : $_josh["site"][$editing . "_dev"];
		}
		?><html>
		<head>
			<title>josh_bottom_frame</title>
			<?php echo josh_draw_javascript();?>
			<script language="javascript">
				<!--
				<?php if (josh_format_text_starts("draw_code_", $action)) {?>
				if (window.addEventListener) {
					window.addEventListener('unload', josh_check, true);
				} else if (element.attachEvent) {
					window.attachEvent('onunload', josh_check);
				}
				function josh_change(mode) {
					if (josh_check(false)) {
						location.href='/j/draw_code_' + mode + '/<?php echo $id_string;?>/';
					} else {
						//set the dropdown back to what it was

					}
				}
				function josh_check(evt) {
					if (josh_get() == document.codeform.original_code.value) return true; //keep going, there are no unsaved changes
					return true; //(confirm("discard changes?"));
				}
				function josh_get() {
					if (typeof(myCpWindow.getCode) == "function") {
						return myCpWindow.getCode();
					} else {
						return document.codeform.myCpWindow.value;
					}
				}
				function josh_save(evt) {
					document.codeform.scroll.value = josh_get_scroll(parent.josh_view);
					document.codeform.original_code.value = josh_get();
					if (document.codeform.is_coding.value == 0) document.codeform.target = "_top";
					document.codeform.submit();
				}
				josh_roll_init("done,save,manage,title,help,todo,logout", "/joshserver/images/bar/");
				<?php } else {?>
				josh_roll_init("edit,approve,discard,manage,title,help,todo,logout", "/joshserver/images/bar/");
				<?php }?>
				//-->
			</script>
		</head>
		<body bgcolor="#999999" style="margin:0px;">
		<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
			<form method="post" action="/" name="titleform" target="josh_view">
				<?php echo josh_draw_form_hidden("j",				"page_update_title");?>
				<?php echo josh_draw_form_hidden("pageID",			$_josh["page"]["id"]);?>
				<?php echo josh_draw_form_hidden("new_title",		$_josh["page"]["title"]);?>
				<?php echo josh_draw_form_hidden("parameter",		@$parameter);?>
				<?php echo josh_draw_form_hidden("scroll",			@$scroll);?>
			</form>
			<form method="post" action="/" name="codeform" target="josh_view">
				<?php echo josh_draw_form_hidden("is_coding",		"1");?>
				<?php echo josh_draw_form_hidden("editing",			@$editing);?>
				<?php echo josh_draw_form_hidden("j",				"page_update");?>
				<?php echo josh_draw_form_hidden("original_code",	htmlentities(@$code));?>
				<?php echo josh_draw_form_hidden("pageID",			$_josh["page"]["id"]);?>
				<?php echo josh_draw_form_hidden("parameter",		@$parameter);?>
				<?php echo josh_draw_form_hidden("scroll",			"0");?>
			<tr height="26" background="/joshserver/images/bar/empty.png">
				<td align="center">
		<?php if ($action == "draw_buttons") {?>
					<table width="661" height="26" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="1"><img src='/joshserver/images/bar/separator.png' width='1' height='26' border='0'></td>
							<td align="center" width="109"><a href="/j/switch/<?php echo $id_string?>/" onmouseover="javascript:josh_roll('edit', 'on');josh_hint('Edit this Page');" onmouseout="javascript:josh_roll('edit', 'off');josh_hint('');" target="_top"><img src="/joshserver/images/bar/edit_off.png" width="109" height="26" border="0" name="edit"></a></td>
							<td width="1"><img src='/joshserver/images/bar/separator.png' width='1' height='26' border='0'></td>
							<?php if ($_josh["page"]["unapproved_content"]) {?>
							<td align="center" width="109"><a href="/j/approve/<?php echo $id_string?>/" onmouseover="javascript:josh_roll('approve', 'on');" onmouseout="javascript:josh_roll('approve', 'off');" target="_top"><img src="/joshserver/images/bar/approve_off.png" width="109" height="26" border="0" name="approve"></a></td>
							<td width="1"><img src='/joshserver/images/bar/separator.png' width='1' height='26' border='0'></td>
							<td align="center" width="109"><a href="/j/discard/<?php echo $id_string?>/" onmouseover="javascript:josh_roll('discard', 'on');" onmouseout="javascript:josh_roll('discard', 'off');" target="_top"><img src="/joshserver/images/bar/discard_off.png" width="109" height="26" border="0" name="discard"></a></td>
							<?php } else {?>
							<td width="109"><img src="/joshserver/images/bar/empty.png" width="109" height="26" border="0"></td>
							<td width="1"><img src='/joshserver/images/bar/separator.png' width='1' height='26' border='0'></td>
							<td width="109"><img src="/joshserver/images/bar/empty.png" width="109" height="26" border="0"></td>
							<?php }?>
							<td width="1"><img src='/joshserver/images/bar/separator.png' width='1' height='26' border='0'></td>
							<td align="center" width="109"><a href="/j/draw_manage/" onmouseover="javascript:josh_roll('manage', 'on');" onmouseout="javascript:josh_roll('manage', 'off');" target="_top"><img src="/joshserver/images/bar/manage_off.png" width="109" height="26" border="0" name="manage"></a></td>
							<td width="1"><img src='/joshserver/images/bar/separator.png' width='1' height='26' border='0'></td>
							<td align="center" width="109"><a href="javascript:top.josh_title(document.titleform.new_title.value);" onmouseover="javascript:josh_roll('title', 'on');" onmouseout="javascript:josh_roll('title', 'off');"><img src="/joshserver/images/bar/title_off.png" width="109" height="26" border="0" name="title"></a></td>
							<td width="1"><img src='/joshserver/images/bar/separator.png' width='1' height='26' border='0'></td>
							<td align="center" width="34"><a href="/j/sys_info/<?php echo $id_string?>/" onmouseover="javascript:josh_roll('help', 'on');" onmouseout="javascript:josh_roll('help', 'off');" target="_top"><img src="/joshserver/images/bar/help_off.png" width="34" height="26" border="0" name="help"></a></td>
							<td width="1"><img src='/joshserver/images/bar/separator.png' width='1' height='26' border='0'></td>
							<td align="center" width="34"><a href="/j/todo/<?php echo $id_string?>/" onmouseover="javascript:josh_roll('todo', 'on');" onmouseout="javascript:josh_roll('todo', 'off');" target="_top"><img src="/joshserver/images/bar/todo_off.png" width="34" height="26" border="0" name="todo"></a></td>
							<td width="1"><img src='/joshserver/images/bar/separator.png' width='1' height='26' border='0'></td>
							<td align="center" width="34"><a href="/j/logout/<?php echo $id_string?>/" onmouseover="javascript:josh_roll('logout', 'on');" onmouseout="javascript:josh_roll('logout', 'off');" target="_top"><img src="/joshserver/images/bar/logout_off.png" width="34" height="26" border="0" name="logout"></a></td>
							<td width="1"><img src='/joshserver/images/bar/separator.png' width='1' height='26' border='0'></td>
						</tr>
					</table>
		<?php } elseif (josh_format_text_starts("draw_code_", $action)) {?>
					<table width="661" height="26" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="1"><img src='/joshserver/images/bar/separator.png' width='1' height='26' border='0'></td>
							<td align="center" width="109"><a href="javascript:document.codeform.is_coding.value=0;josh_save(false);" onmouseover="javascript:josh_roll('done', 'on');" onmouseout="javascript:josh_roll('done', 'off');"><img src="/joshserver/images/bar/done_off.png" width="109" height="26" border="0" name="done"></a></td>
							<td width="1"><img src='/joshserver/images/bar/separator.png' width='1' height='26' border='0'></td>
							<td align="center" width="109"><a href="javascript:josh_save(false);" onmouseover="javascript:josh_roll('save', 'on');" onmouseout="javascript:josh_roll('save', 'off');"><img src="/joshserver/images/bar/save_off.png" width="109" height="26" border="0" name="save"></a></td>
							<td width="1"><img src='/joshserver/images/bar/separator.png' width='1' height='26' border='0'></td>
							<td align="center" width="109">
								<select onchange="javascript:josh_change(this.value);" style="background-color:#000; color:#eeeeee; font-family:verdana; font-size:13px; border-width:0px;">
								<?php
									$options = array("Post", "CSS", "Header", "Page", "Footer");
									foreach ($options as $option) {
										$opt = strtolower($option);
										echo "<option value='" . $opt . "'";
										if ($opt == $editing) echo " selected";
										echo ">" . $option . "</option>";
									}
								?>
								</select>
							</td>
							<td width="1"><img src='/joshserver/images/bar/separator.png' width='1' height='26' border='0'></td>
							<td align="center" width="109"><a href="/j/draw_manage/" onmouseover="javascript:josh_roll('manage', 'on');" onmouseout="javascript:josh_roll('manage', 'off');" target="_top"><img src="/joshserver/images/bar/manage_off.png" width="109" height="26" border="0" name="manage"></a></td>
							<td width="1"><img src='/joshserver/images/bar/separator.png' width='1' height='26' border='0'></td>
							<td align="center" width="109"><a href="javascript:top.josh_title(document.titleform.new_title.value);" onmouseover="javascript:josh_roll('title', 'on');" onmouseout="javascript:josh_roll('title', 'off');"><img src="/joshserver/images/bar/title_off.png" width="109" height="26" border="0" name="title"></a></td>
							<td width="1"><img src='/joshserver/images/bar/separator.png' width='1' height='26' border='0'></td>
							<td align="center" width="34"><a href="/j/sys_info/<?php echo $_josh["page"]["id"]?>/" onmouseover="javascript:josh_roll('help', 'on');" onmouseout="javascript:josh_roll('help', 'off');" target="_top"><img src="/joshserver/images/bar/help_off.png" width="34" height="26" border="0" name="help"></a></td>
							<td width="1"><img src='/joshserver/images/bar/separator.png' width='1' height='26' border='0'></td>
							<td align="center" width="34"><a href="/j/todo/<?php echo $_josh["page"]["id"]?>/" onmouseover="javascript:josh_roll('todo', 'on');" onmouseout="javascript:josh_roll('todo', 'off');" target="_top"><img src="/joshserver/images/bar/todo_off.png" width="34" height="26" border="0" name="todo"></a></td>
							<td width="1"><img src='/joshserver/images/bar/separator.png' width='1' height='26' border='0'></td>
							<td align="center" width="34"><a href="/j/logout/<?php echo $_josh["page"]["id"]?>/" onmouseover="javascript:josh_roll('logout', 'on');" onmouseout="javascript:josh_roll('logout', 'off');" target="_top"><img src="/joshserver/images/bar/logout_off.png" width="34" height="26" border="0" name="logout"></a></td>
							<td width="1"><img src='/joshserver/images/bar/separator.png' width='1' height='26' border='0'></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td><textarea id="myCpWindow" name="myCpWindow" class="codepress <?php if ($editing == "css") {?>css<?php }else{?>php<?php }?>" style="width:100.3%; font-family:courier; font-size:13px; height:<?php echo ($_josh["user"]["drawer_size"]-19);?>"><?php echo $code;?></textarea>
		<?php }?>
				</td>
			</tr>
			</form>
		</table>
		</body>
		</html><?php
		exit;
	} elseif (($action == "draw_manage") && $_josh["user"]) {
		$return  = "<table width='1000' cellpadding='0' cellspacing='0' border='0' class='josh_message'>
						<tr valign='top'>
							<td width='33%'>
								<table class='josh_smaller' cellpadding='3' cellspacing='1' border='0' width='100%' bgcolor='" . $_josh["colors"]["grey2"] . "'>
									<tr class='josh_heading' bgcolor='" . $_josh["colors"]["white"] . "'>
										<td colspan='4' height='32' style='padding:8px;'>USERS</td>
									</tr>
									<tr bgcolor='" . $_josh["colors"]["grey1"] . "'>
										<td width='160'>name</td>
										<td width='47'>admin?</td>
										<td width='120' align='right'>last activity</td>
										<td width='16'>" . josh_draw_spacer(16) . "</td>
									</tr>";
		$users = josh_db_query("SELECT u.id, u.name, u.email, u.is_active, u.last_active, u2s.is_admin FROM josh_users u JOIN josh_users_to_sites u2s ON u.id = u2s.userID WHERE u2s.siteID = {$_josh["site"]["id"]} ORDER BY u.name");
		while ($u = josh_db_fetch($users)) {
			$return .= "			<tr bgcolor='" . $_josh["colors"]["white"] . "'>
										<td height='32'><a href='mailto:" . $u["email"] . "' class='josh_dark'>" . ucfirst($u["name"]) . "</a></td>
										<td>" . josh_format_boolean($u["is_admin"]) . "</td>
										<td align='right'>" . josh_format_date_time($u["last_active"]) . "</td>
										<td>" . josh_format_link("icon_delete", "user_delete", $u["id"]) . "</td>
									</tr>";
		}
		$return .= "				<tr bgcolor='" . $_josh["colors"]["white"] . "' class='josh_message' valign='top'>
										<td colspan='4' style='padding:8px;' height='164'><b>invite new users</b><br>to invite another user to code or manage your sites, use the form below.";
		$form = new josh_draw_table_form;
		$form->add_row("text", "email");
		$form->add_row("checkbox", "is_admin", 0, "admin?");
		$return .= $form->draw("user_invite", "send invitation");

		$return .= "					</td>
									</tr>
									<tr bgcolor='" . $_josh["colors"]["white"] . "' class='josh_message' valign='top'>
										<td colspan='4' style='padding:8px;' height='164'><b>measuring traffic</b><br>you can use <a href='http://www.google.com/analytics/' class='josh_dark'>google analytics</a> to track the number of visitors to " . $_josh["site"]["url"] . ".  after you've set up an account with google 
										and registered your site, enter your <a href='https://www.google.com/support/googleanalytics/bin/answer.py?answer=55603' class='josh_dark'>tracking code</a> in the box below.  joshserver will then automatically append the right javascript to all of your
										non-protected pages.";
		$form = new josh_draw_table_form;
		$form->add_row("text", "tracking_code", @$_josh["site"]["tracking_code"], "code");
		$return .= $form->draw("tracking_code_update", "add code");
		$return .= "				</td>
									</tr>
								</table>
							</td>
							<td width='10'>" . josh_draw_spacer(10) . "</td>
							<td width='33%'>
								<table class='josh_smaller' cellpadding='3' cellspacing='1' border='0' width='100%' bgcolor='" . $_josh["colors"]["grey2"] . "'>
									<tr class='josh_heading' bgcolor='" . $_josh["colors"]["white"] . "'>
										<td colspan='7' height='32' style='padding:8px;'>PAGES</td>
									</tr>
									<tr bgcolor='" . $_josh["colors"]["grey1"] . "'>
										<td width='16'>" . josh_draw_spacer(16) . "</td>
										<td width='180'>name</td>
										<td width='80' align='right'>updated</td>
										<td width='16'>" . josh_draw_spacer(16) . "</td>
										<td width='16'>" . josh_draw_spacer(16) . "</td>
										<td width='16'>" . josh_draw_spacer(16) . "</td>
										<td width='16'>" . josh_draw_spacer(16) . "</td>
									</tr>";
		$pages = josh_db_query("SELECT p.id, p.parentID, p.title, (SELECT MAX(g.sequence) FROM josh_pages g WHERE g.siteID = {$_josh["site"]["id"]}) sequence_max, p.sequence, p.folder, p.modified_on, p.approved_on, p.is_private FROM josh_pages p WHERE p.siteID = {$_josh["site"]["id"]} ORDER BY p.sequence");
		while ($p = josh_db_fetch($pages)) {
			$return .= "			<tr bgcolor='" . $_josh["colors"]["white"] . "' height='32'>
										<td height='32'>";
							if ($p["is_private"]) {
								$return .= josh_format_link("icon_lock", "page_unlock", $p["id"]);
							} else {
								$return .= josh_format_link("spacer", "page_lock", $p["id"]);
							}
							$return .= "</td><td";
							if ($p["parentID"]) $return .= " style='padding-left:15px;'";
							$return .= "><a href='/";
							if ($p["folder"]) $return .= $p["folder"] . "/";
							$return .= "' class='josh_dark'>" . $p["title"] . "</a></td>
										<td align='right'>" . josh_format_date($p["approved_on"]) . "</td>
										<td>";
							if ($p["sequence"] != 1) {
								if ($p["parentID"]) {
									$return .= josh_format_link("icon_moveleft", "page_move_left", $p["id"]);
								} else {
									$return .= josh_format_link("icon_moveright", "page_move_right", $p["id"]);
								}
							}
							$return .= "</td><td>";
							if ($p["sequence"] != 1) $return .= josh_format_link("icon_moveup", "page_move_up", $p["id"]);
							$return .= "</td><td>";
							if ($p["sequence"] != $p["sequence_max"]) $return .= josh_format_link("icon_movedown", "page_move_down", $p["id"]);
							$return .= "</td><td>";
							if ($p["sequence"] != 1) $return .= josh_format_link("icon_delete", "page_delete", $p["id"]);
							$return .= "</td>
									</tr>";
		}
		$return .= "				<tr bgcolor='" . $_josh["colors"]["white"] . "' class='josh_message' valign='top'>
										<td colspan='7' style='padding:8px;' height='98'><b>adding new pages</b><br>to create a new page on this site, start by going to the address you want in your location bar.  you will see a 'page not found' error, along with a form to allow you to create a new page in that location.</td>
									</tr>
									<tr bgcolor='" . $_josh["colors"]["white"] . "' class='josh_message' valign='top'>
										<td colspan='7' style='padding:8px;' height='98'><b>approving and discarding</b><br>";
							if ($_josh["site"]["pages_pending"]) {
								$return .= "you have " . josh_format_quantitize($_josh["site"]["pages_pending"], "page") . " in need of approval.  you can " . josh_format_link("approve all", "approve_all") . " or " . josh_format_link("discard all", "discard_all") . ", if you are feeling confident.";
							} else {
								$return .= "nothing pending.";
							}
							
		$return .= "					</td>
									</tr>
									<tr bgcolor='" . $_josh["colors"]["white"] . "' class='josh_message' valign='top'>
										<td colspan='7' style='padding:8px;' height='98'><b>backing up</b><br>it's always a good idea to back up your data.  " . josh_format_link("click this link", "backup") . " to produce an XML backup of this site that you can save locally.</td>
									</tr>
									<tr bgcolor='" . $_josh["colors"]["white"] . "' class='josh_message' valign='top'>
										<td colspan='7' style='padding:8px;' height='98'><b>restoring from backup</b><br>this will overwrite your current pages with what's in the XML file you attach here.";
		$form = new josh_draw_table_form;
		$form->add_row("file", "file", false, "XML file");
		$return .= $form->draw("site_restore", "restore");
										
		$return .= "					</td>
									</tr>
									<tr bgcolor='" . $_josh["colors"]["white"] . "' class='josh_message' valign='top'>
										<td colspan='7' style='padding:8px;' height='98'><b>starting fresh</b><br>you can also " . josh_format_link("delete this site", "site_delete") . " or " . josh_format_link("delete all your sites", "destroy") . " and start over completely, if you so desire.</td>
									</tr>
								</table>
							</td>
							<td width='10'>" . josh_draw_spacer(10) . "</td>
							<td width='33%'>
								<table class='josh_smaller' cellpadding='3' cellspacing='1' border='0' width='100%' bgcolor='" . $_josh["colors"]["grey2"] . "'>
									<tr class='josh_heading' bgcolor='" . $_josh["colors"]["white"] . "'>
										<td colspan='";
		$colspan = ($_josh["user"]["is_admin"]) ? 5 : 4;
		$return .= $colspan . "' height='32' style='padding:8px;'>OBJECTS</td>
									</tr>
									<tr bgcolor='" . $_josh["colors"]["grey1"] . "'>
										<td width='16'>" . josh_draw_spacer(16) . "</td>
										<td width='246'>name</td>
										<td width='32' align='center'>obj</td>
										<td width='32' align='center'>com</td>";
		if ($_josh["user"]["is_admin"]) $return .= "<td width='16'>" . josh_draw_spacer(16) . "</td>";
		$return .= 					"</tr>";
		$objects = josh_object_types_get();
		while ($o = josh_db_fetch($objects)) {
			$return .= "			<tr bgcolor='" . $_josh["colors"]["white"] . "'>
										<td height='32'>";
							if ($o["is_private"]) {
								$return .= josh_format_link("icon_lock", "object_type_unlock", $o["id"]);
							} else {
								$return .= josh_format_link("spacer", "object_type_lock", $o["id"]);
							}
			$return .= "				</td>
										<td>" . josh_format_link($o["name_plural"], "object_type", $o["id"]) . "</td>
										<td align='center'>" . $o["num_objects"] . "</td>
										<td align='center'>" . "</td>";
			if ($_josh["user"]["is_admin"]) $return .= "<td>" . josh_format_link("icon_delete", "object_type_delete") . "</td>";
			$return .= 				"</tr>";
		}
		$return .= "				<tr bgcolor='" . $_josh["colors"]["white"] . "' class='josh_message' valign='top' height='164'>
										<td colspan='" . $colspan . "' style='padding:8px;'><b>create a new object</b><br>to start another type of object, enter a one-word name in the form below.  ";
		$form = new josh_draw_table_form;
		$form->add_row("text", "name_singular", "", "name");
		$form->add_row("checkbox", "is_private", 0, "private?");
		$return .= $form->draw("object_type_add", "add object type");

		$return .= "			</table>
							</td>
						</tr>";
		$return .= "</table>";
		echo josh_draw_page("manage <span class='josh_manage_site'>" . $_josh["site"]["url"] . "</div>", $return);
	} elseif  ($action == "draw_view") {
		//i believe we're making the assumption that the correct site is already loaded.  i can't imagine a case where that wouldn't be true, so we're going with it
		//also wondering whether this mode is absolutely necessary.  wouldn't it be best just to have the regular page address in the view frame?
		//no.  what would happen is that the view frame would itself produce a frameset etc to infinity.  is there another method of identification?  
		$_josh["page"] = josh_sys_page($id);
		josh_draw_eval("dev", false, $parameter, $scroll);
	}
	//draw action but not authorized
	josh_sys_refresh(false);
}

function josh_draw_array($array, $nice=false) {
	global $_josh;
	$return = '<table width="100%" cellpadding="3" cellspacing="1" border="0" bgcolor="' . $_josh["colors"]["grey2"] . '">';
	if (!$nice) ksort($array);
	while(list($key, $value) = each($array)) {
		if ($nice && (strToLower($key) == "j")) continue;
		if (is_int($key)) continue;
		$value = josh_format_unesc($value);
		if (strToLower($key) == "email") $value = "<a href='mailto:" . $value . "'>" . $value . "</a>";
		if (is_array($value)) {
			$return2 = "";
			foreach ($value as $key2 => $value2) {
				$return2 .= "&#183; " . $value2 . "<br>";
			}
			$value = $return2;
		}
		$return  .= '
			<tr bgcolor="' . $_josh["colors"]["white"] . '" style="font-family: verdana; font-size:11px; padding:6px; line-height:16px; width:100%;" valign="top"';
		if (strToLower($key) == "message") $return .= ' height="160"';
		$return .= '><td bgcolor="' . $_josh["colors"]["grey1"] . '" width="21%"><nobr>';
		$return .= ($nice) ? josh_format_text_human($key)  : $key;
		$return .= '&nbsp;</nobr></td><td width="79%">' . nl2br($value) . '</td></tr>';
	}
	$return .= '</table>';
	return $return;
}

function josh_draw_css() {
	global $_josh;
	if (!$_josh["drawn"]["css"]) {
		$_josh["drawn"]["css"] = true;
		return ('<style type="text/css">
			<!--
			.josh_body			{ margin:0px; background-color:' . $_josh["colors"]["grey3"] . '; font-family:verdana, arial, sans-serif; }
			.josh_title			{ font-family:verdana, arial, sans-serif; font-size:20px; font-weight:bold; }
			.josh_heading		{ font-family:verdana, arial, sans-serif; font-size:14px; }
			.josh_heading_large	{ font-family:verdana, arial, sans-serif; font-size:17px; }
			.josh_manage_site	{ font-family:verdana, arial, sans-serif; font-size:20px; font-weight:bold; color:' . $_josh["colors"]["red2"] . '; background-color:' . $_josh["colors"]["yellow"] . '; }
			.josh_message		{ font-family:verdana, arial, sans-serif; font-size:12px; }
			.josh_smaller		{ font-family:verdana, arial, sans-serif; font-size:10px; }
			.josh_small			{ font-family:verdana, arial, sans-serif; font-size:9px; }
			.josh_field			{ background-color:' . $_josh["colors"]["grey2"] . '; font-family:verdana, arial, sans-serif; font-size:11px; border-width:1px; padding:2px;  }
			.josh_button		{ font-family:verdana, arial, sans-serif; background-color:' . $_josh["colors"]["grey4"] . '; font-size:10px; width:130px; border-width:1px; color: ' . $_josh["colors"]["white"] . ';}
			.josh_button_prompt	{ font-family:verdana, arial, sans-serif; background-color:' . $_josh["colors"]["grey2"] . '; font-size:10px; width:130px; border-width:1px; color: ' . $_josh["colors"]["grey5"] . ';}
			.josh_code          { font-family:courier new, courier; font-size:11px; }
			.josh_drawer_open	{ background-color:' . $_josh["colors"]["grey5"] . '; margin:0px; margin-top:13px; }
			.josh_drawer_closed { background-color:' . $_josh["colors"]["grey5"] . '; margin:0px; margin-top:13px; }
			a.josh_dark:link	{ color:' . $_josh["colors"]["red2"] . '; }
			a.josh_dark:active	{ color:' . $_josh["colors"]["red2"] . '; }
			a.josh_dark:visited	{ color:' . $_josh["colors"]["red2"] . '; }
			a.josh_dark:hover	{ color:' . $_josh["colors"]["red1"] . '; }
			a.josh_lite:link	{ color:' . $_josh["colors"]["white"] . '; text-decoration:none; }
			a.josh_lite:active	{ color:' . $_josh["colors"]["white"] . '; text-decoration:none; }
			a.josh_lite:visited	{ color:' . $_josh["colors"]["white"] . '; text-decoration:none; }
			a.josh_lite:hover	{ color:' . $_josh["colors"]["white"] . '; text-decoration:underline; }
			span.clickable:hover	{ background-color:#f3f3f3; cursor:hand; cursor:pointer; }
			-->
		</style>');
	}
}
 
function josh_draw_eval($what, $page=false, $itemID=false, $scroll=false) {
	global $_josh, $_GET, $_POST, $_SERVER, $_COOKIE;
	$_josh["context"] = "user";
	if (isset($_SERVER["REDIRECT_QUERY_STRING"])) {
		$items = explode("&", $_SERVER["REDIRECT_QUERY_STRING"]);
		foreach ($items as $item) {
			list($key, $value) = explode("=", $item);
			$_GET[$key] = urldecode($value);
		}
	}
	$_josh["site"]["css"] =  "<style type='text/css'>" . $_josh["site"]["css_" . $what] . "</style>";
	if ($what == "dev") echo "<base target='_top'>";
	if (!$page) $page = $_josh["page"]["content_" . $what];
	$pagetext =  $_josh["site"]["header_"  . $what] . $page . $_josh["site"]["footer_"  . $what];
	
	//enabling double-spaced sentences.  thought that would be nice, although random
	//todo - find a way that this won't interfere with code (JS or PHP)
	$pagetext = str_replace(".  ", ".&nbsp; ", $pagetext);
	$pagetext = str_replace("?  ", "?&nbsp; ", $pagetext);
	$pagetext = str_replace("!  ", "!&nbsp; ", $pagetext);
	$pagetext = str_replace(")  ", ")&nbsp; ", $pagetext);
	$pagetext = str_replace('"  ', '"&nbsp; ', $pagetext);
	$pagetext = str_replace("'  ", "'&nbsp; ", $pagetext);
	
	//expanding short tags -- don't know whether it's enabled
	$pagetext = str_replace("<?", "<?php ",			$pagetext);
	$pagetext = str_replace("<?php php", "<?php ",	$pagetext);
	$pagetext = str_replace("<?php =", "<?php echo ",	$pagetext);
	
	//adding google analytics tracking code.  nb don't have two </body> tags bc that would be weird!
	if ($_josh["site"]["tracking_code"] && @!$_josh["page"]["is_private"] && ($what == "live")) $pagetext = str_replace("</body>", josh_draw_google_tracker($_josh["site"]["tracking_code"]) . "</body>", $pagetext);
	
	extract($_josh);
	$id = ($itemID) ? $itemID : @$_josh["page"]["slot2"];
	eval("?>" . $pagetext);
	if ($scroll) {?>
	<script language="javascript">
		<!--
		window.scrollBy(0, <?php echo $scroll;?>);
		//-->
	</script>
	<?php }
	josh_db_close();
}

function josh_draw_eval_post($what) {
	global $_josh, $_GET, $_POST, $_SERVER, $_COOKIE;
	if (empty($_POST) || isset($_POST["j"])) return false;
	$_josh["context"] = "user";
	extract($_josh);
	extract($_POST);
	eval($_josh["site"]["post_"  . $what]);
	$redirect = (isset($redirect)) ? $redirect : str_replace("view", "redirect", $_SERVER["HTTP_REFERER"]);
	josh_sys_refresh($redirect);
}

function josh_draw_form_button($text, $javascript=false, $disabled=false, $class="josh_button") {
	if (!$javascript) $javascript = "return false;";
	$return  = '<input type="button" value="' . $text . '" id="' . $text . '" class="' . $class . '" onclick="' . $javascript . '"';
	if ($disabled) $return .= ' disabled';
	$return .= '>';
	return $return;
}

function josh_draw_form_checkbox($name, $checked=false) {
	//need the id for javascript getelementbyid
	$return  = '<input type="checkbox" name="' . $name . '" id="' . $name . '" class="josh_field"';
	if ($checked) $return .= ' checked';
	$return .= '>';
	return $return;
}

function josh_draw_form_date($namePrefix, $timestamp=false, $withTime=false) {
	global $_josh;

	//get time into proper format
	if (!($timestamp)) $timestamp = time();
	if (!is_int($timestamp)) $timestamp = strToTime($timestamp);
	$month  = date("n", $timestamp);
	$day    = date("j", $timestamp);
	$year   = date("Y", $timestamp);
	$hour   = date("g", $timestamp);
	$minute = date("i", $timestamp);
	$ampm   = date("A", $timestamp);

	//assemble date fields
	$return  = '<nobr><select name="' . $namePrefix . 'Month" class="josh_field">';
	for ($i = 1; $i < 13; $i++) {
		$return .= '<option value="' . $i . '"';
		if ($i == $month) $return .= ' selected';
		$return .= '>' . $_josh["months"][$i-1] . '</option>';
	}
	$return .= '</select>';
	$return .= '&nbsp;<select name="' . $namePrefix . 'Day" class="josh_field">';
	for ($i = 1; $i < 32; $i++) {
		$return .= '<option value="' . $i . '"';
		if ($i == $day) $return .= ' selected';
		$return .= '>' . $i . '</option>';
	}
	$return .= '</select>';
	$return .= '&nbsp;<select name="' . $namePrefix . 'Year" class="josh_field">';
	for ($i = 1910; $i < 2030; $i++) {
		$return .= '<option value="' . $i . '"';
		if ($i == $year) $return .= ' selected';
		$return .='>' . $i . '</option>';
	}
	$return .= '</select></nobr>';
	
	if ($withTime) {
		$return .= '&nbsp;&nbsp;<select name="' . $namePrefix . 'Hour" class="josh_field">';
		$return .= '<option value="12"';
		if ($hour == 12) $return .= ' selected';
		$return .= '>12</option>';
		for ($i = 1; $i < 12; $i++) {
			$return .= '<option value="' . $i . '"';
			if ($hour == $i) $return .= ' selected';
			$return .= '>' . $i . '</option>';
		}
		$return .= '</select>&nbsp;<select name="' . $namePrefix . 'Minute" class="josh_field">';
			$return .= '<option value="00"';
			if ($minute == 0) $return .= ' selected';
			$return .='>00</option>';
			for ($i = 1; $i < 60; $i++) {
				$return .= '<option value="' . $i . '"';
				if ($minute == $i) $return .= ' selected';
				$return .= '>' . sprintf("%02d", $i) . '</option>';
			}
			/*$return .= '<option value="15"';
			if ($minute == 15) $return .= ' selected';
			$return .='>15</option>';
			$return .= '<option value="30"';
			if ($minute == 30) $return .= ' selected';
			$return .='>30</option>';
			$return .= '<option value="45"';
			if ($minute == 45) $return .= ' selected';
			$return .='>45</option>';*/
		$return .= '</select>&nbsp;<select name="' . $namePrefix . 'AMPM" class="josh_field">';
			$return .= '<option value="AM"';
			if ($ampm == "AM") $return .= ' selected';
			$return .='>AM</option><option value="PM"';
			if ($ampm == "PM") $return .= ' selected';
			$return .='>PM</option></select>';
	}
	
	//return string
	return $return;
}

function josh_draw_form_hidden($name, $value="") {
	return '<input type="hidden" name="' . $name . '" value="' . $value . '">';
}

function josh_draw_form_password($name, $value="", $class="josh_field", $width=false, $maxlength=255) {
	$return = '<input type="password" name="' . $name . '" value="' . $value . '" class="' . $class . '" maxlenth="' . $maxlength . '"';
	if ($width) $return .= ' style="width:' . $width . ';"';
	$return .= '>';
	return $return;
}

function josh_draw_form_radio($name, $checked=false) {
	$return  = '<input type="radio" name="' . $name . '" " class="josh_field"';
	if ($checked) $return .= ' checked';
	$return .= '>';
	return $return;
}

function josh_draw_form_select($name, $sql, $selectedID=false, $nullable=false, $action=false) {
	$return  = '<select name="' . $name . '" class="josh_field"';
	//if ($action) $return .= 'onchange="javascript:location.href=\'' . dropQueryValues($name) . '&' . $name . '=\' + this.value;"';
	$return .= '>';
	if ($nullable) $return .= "<option></option>";
	$result = josh_db_query($sql);
	while ($r = josh_db_fetch($result)) {
		$return .= '<option value="' . $r[0] . '"';
		if ($r[0] == $selectedID) $return .= ' selected';
		$return .= '>' . $r[1] . '</option>';
	}
	$return .= '</select>';
	return $return;
}

function josh_draw_form_submit($name="SUBMIT FORM") {
	return '<input type="submit" value="   ' . $name . '   " class="josh_button">';
}

function josh_draw_form_text($name, $value="", $class="josh_field", $width=false, $maxlength=255) {
	$return = '<input type="text" name="' . $name . '" value="' . $value . '" class="' . $class . '" maxlenth="' . $maxlength . '"';
	if ($width) $return .= ' style="width:' . $width . ';"';
	$return .= '>';
	return $return;
}

function josh_draw_form_textarea($name, $value="", $class="josh_field", $width=false, $height=false) {
	$return = '<textarea name="' . $name . '" id="' . $name . '" class="' . $class . '"';
	if ($width) $return .= ' style="width:' . $width . '; height:' . $height . ';"';
	$return .= '>' . $value . '</textarea>';
	return $return;
}

function josh_draw_google_tracker($id) {
	$return = '
		<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
		<script type="text/javascript">
			_uacct = "' . $id . '";
			urchinTracker();
		</script>
	';
	return $return;
}

function josh_draw_img($path, $link=false) {
	//this function is just for fun bc it makes improbable assumptions about what the user wants to do
	list($category, $filename) = explode("/", $path);
	list($name, $type) = explode(".", $filename);
	if ($image = @getimagesize("images/" . $path)) {
		$width	= $image[0];
		$height	= $image[1];
		$return = '<img src="/images/' . $path . '" width="' . $width . '" height="' . $height . '" border="0"/>';
		if ($link) $return = '<a href="/' . $name . '/">' . $return . '</a>';
		return $return;
	}
}

function josh_draw_javascript() {
	global $_josh;
	if (!$_josh["drawn"]["js"]) {
		$_josh["drawn"]["js"] = true;
		return '
			<script type="text/javascript" src="/joshserver/javascript.js"></script>
			<script type="text/javascript" src="/joshserver/codepress/codepress.js"></script>
			<script type="text/javascript" src="/joshserver/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
			<script type="text/javascript">
				<!--
					tinyMCE.init({
						mode : "textareas",
						theme : "advanced",
						theme_advanced_buttons1 : "bold,italic,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,link,unlink,|,image,code",
						theme_advanced_buttons2 : "",
						theme_advanced_buttons3 : "",
						theme_advanced_toolbar_location : "top",
						theme_advanced_toolbar_align : "left",
						extended_valid_elements : "a[name|href|target|title|class],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style],object[type|data|width|height|allowfullscreen|id],param[name|value],embed[src|quality|width|height|name|type]",
						editor_selector : "mceEditor",
						editor_deselector : "mceNoEditor",
						content_css : "/j/css/?" + new Date().getTime(),
						relative_urls : false,
						remove_script_host : true,
						document_base_url : "http://' . @$_josh["site"]["url"] . '/"
					});
					//site->url might not be set above
				//-->
			</script>';
	}
}

function josh_draw_onoff($title="") {
	global $_josh;
	if (strToLower($_josh["page"]["title"]) == strToLower($title)) return "on";
	return "off";
}

function josh_draw_page($title, $html, $severe=false, $keepalive=false) {
	global $_josh;
	josh_sys_debug("drawing page");
	if ($severe) $title = "<font color='" . $_josh["colors"]["red2"] . "'>" . $title . "</font>";
	$return = "<html>
		<head>
			<title>" . strip_tags($title) . "</title>
			" . josh_draw_css() . "
			<script language='javascript'>
				<!--
				function josh_confirm(action, message, id) {
					var url = '/j/' + action + '/';
					if (id) url += '/' + id + '/';
					if (confirm('Are you sure you want to ' + message + '?')) location.href = url;
				}
				//-->
			</script>
		</head>
		<body class='josh_body' bgcolor='" . $_josh["colors"]["grey3"] . "'>
			<table width='100%' height='100%' cellpadding='0' cellspacing='0' border='0'>
				<tr height='90%'>
					<td align='center' height='350'>
						<table width='400' height='250' cellpadding='20' cellspacing='0' border='0' bgcolor='" . $_josh["colors"]["white"] . "'>
							<tr>
								<td valign='top'>
								<div class='josh_title'>" . $title . "</div>
								<br>
								<div class='josh_message'>" . $html . "</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr height='10%'>
					<td height='50' align='center' style='color:" . $_josh["colors"]["white"] . "; font-size:11px;'>powered by " . josh_format_link("joshserver", $_josh["website"], false, "josh_lite", true) . "</td>
				</tr>
			</table>
		</body>
	</html>";
	if ($keepalive) return $return;
	echo $return;
	josh_db_close();
}

function josh_draw_robots() {
	global $_josh;
	$return = "# /robots.txt file for http://" . $_josh["site"]["url"] . "/" . $_josh["newline"] . $_josh["newline"];
	$return .= "User-agent: *" . $_josh["newline"];
	$return .= "Disallow: /j" . $_josh["newline"];
	$return .= "Disallow: /joshserver";

	//get private pages to add to the list
	$pages = josh_db_query("SELECT folder FROM josh_pages WHERE is_private = 1 AND siteID = " . $_josh["site"]["id"]);
	while ($p = josh_db_fetch($pages)) $return .= $_josh["newline"] . "Disallow: /" . $p["folder"];

	return $return;
}

function josh_draw_sections($section_yes, $section_no, $separator) {
	global $_josh;
	$entities = array();
	$sections = josh_db_query("SELECT p.id, p.title, p.folder FROM josh_pages p WHERE p.parentID IS NULL AND p.siteID = {$_josh["site"]["id"]} ORDER BY p.sequence");
	while ($s = josh_db_fetch($sections)) {
		if ($s["folder"] == "") {
			$s["folder"] = "home";
			$url = "/";
		} else {
			$url = "/" . $s["folder"] . "/";
		}
		if (($_josh["page"]["id"] == $s["id"]) || ($_josh["page"]["parentID"] == $s["id"])) {
			$current = str_replace("_joshurl",		$url,			$section_yes);
			$current = str_replace("_joshfolder",	$s["folder"],   $current);
			$current = str_replace("_joshname",		$s["title"],	$current);
		} else {
			$current = str_replace("_joshurl",		$url,			$section_no);
			$current = str_replace("_joshfolder",	$s["folder"],   $current);
			$current = str_replace("_joshname",		$s["title"],	$current);
		}
		$entities[] = $current;
	}
	return implode($separator, $entities);
}

function josh_draw_spacer($width=1, $height=1, $border=0) {
	global $_josh;
	return '<img src="/joshserver/images/spacer.png" width="' . $width . '" height="' . $height . '" border="' . $border . '">';
}

class josh_draw_table_form {
	var $autofocus			= true;
	var $border				= 0;
	var $context			= false;
	var $field_width		= false;
	var $focus				= false;
	var $header				= false;
	var $rows				= array();
	var $valid				= "";
	var $textarea_height    = 120;
	var $text_orientation	= "left"; // left, top, off
	var $colspan			= 2;
	var $color_border		= false;
	var $color_background	= false;
	var $color_alt			= false;
	var $cellpadding		= 3;
	var $cellspacing		= 1;
	var $valign				= "middle";
	function add_row($type, $name="", $value=false, $message=false, $sql_options=false, $disabled=false, $required=true) {
		global $_josh;
		if (!$message) $message = str_replace("josh_", "", $name);
		$return = "<tr height='30'>";
		if ($this->text_orientation == "left") {
			$return .= "<td align='right' valign='";
			$return .= (($type == "textarea") || ($type == "textarea-rich") || ($type == "checkboxes")) ? "top" : $this->valign;
			$return .= "' bgcolor='" . $this->color_alt . "'>" . $message . "</td>";
		}
		$return .= "<td bgcolor='" . $this->color_background . "'>";
		if ($this->text_orientation == "top") $return .= $message . "<br>";
		if ($type == "text") {
			if (!$this->focus && !$value)    $this->focus  = $name;
			if ($required)        $this->valid .= "if (!form." . $name . ".value.length) errors[errors.length] = 'the \'" . strip_tags($message) . "\' field is empty';\n";
			if ($name == "email") $this->valid .= "if (form.email.value.length && !josh_is_email(form.email.value)) errors[errors.length] = 'the email address you entered doesn\'t appear to be valid';\n";
			$return .= josh_draw_form_text($name, $value, "josh_field", $this->field_width);
		} elseif ($type == "password") {
			if (!$this->focus && !$value)    $this->focus  = $name;
			if ($required)        $this->valid .= "if (!form." . $name . ".value.length) errors[errors.length] = 'the \'" . strip_tags($message) . "\' field is empty';\n";
			if ($name == "email") $this->valid .= "if (form.email.value.length && !josh_is_email(form.email.value)) errors[errors.length] = 'the email address you entered doesn\'t appear to be valid';\n";
			$return .= josh_draw_form_password($name, $value, "josh_field", $this->field_width);
		} elseif ($type == "checkbox") {
			$return .= josh_draw_form_checkbox($name, $value);
		} elseif ($type == "checkboxes") {
			//value should be an array with id / name / selected as the first three elements
			//name should be the flag_typeID
			$total = count($value);
			if ($total) {
				$counter = 0;
				$max = $total / 3;
				$max--;
				$return .= '<table cellpadding="3" cellspacing="0" border="0" width="100%"><tr style="vertical-align:top;">';
				foreach ($value as $v) {
					if ($counter == 0) $return .= '<td width="33%"><table cellpadding="0" cellspacing="0" border="0" width="100%">';
					$return .= '
						<tr class="josh_smaller" valign="middle" height="22">
						<td width="1%">' . josh_draw_form_checkbox("flag_" . $name . "_" . $v["id"], $v["checked"]) . '</td>
						<td width="99%"><span class="clickable" onclick="javascript:josh_checkbox(\'flag_' . $name . '_' . $v["id"] . '\');">' . $v["name"] . '</span></td>
						</tr>';
					if ($counter > $max) {
						$return .= '</table></td>';
						$counter = 0;
					} else {
						$counter++;
					}
				}
				if ($counter != $max) $return .= '</table></td>';
				$return .= '</tr></table>';
			}
		} elseif ($type == "textarea") {
			if (!$this->focus && !$value)    $this->focus  = $name;
			if ($required)     $this->valid .= "if (!form." . $name . ".value.length) errors[errors.length] = 'the \'" . strip_tags($message) . "\' field is empty';\n";
			$return .= josh_draw_form_textarea($name, $value, "josh_field", $this->field_width, $this->textarea_height);
		} elseif ($type == "textarea-rich") {
			if (!$this->focus && !$value)    $this->focus  = $name;
			if ($required)     $this->valid .= "tinyMCE.triggerSave(); if (!form." . $name . ".value.length) errors[errors.length] = 'the \'" . strip_tags($message) . "\' field is empty';\n";
			$return .= josh_draw_form_textarea($name, $value, "mceEditor", $this->field_width-2, $this->textarea_height);
		} elseif ($type == "select") {
			$return .= "<select name='" . $name . "' class='josh_field'";
			//if ($disabled) $return .= " disabled";
			$return .= ">";
			if (!$required) {
				$return .= "<option value=''";
				if (!$value) $return .= " selected";
				$return .= "></option>";
			}
			if (is_array($sql_options)) {
				while (list($key, $val) = each($sql_options)) {
					$return .= "<option value='" . $key . "'";
					if ($key == $value) $return .= " selected";
					$return .= ">" . $val . "</option>";
				}
			} else {
				$result = josh_db_query($sql_options);
				while ($r = josh_db_fetch($result)) {
					$return .= "<option value='" . $r[0] . "'";
					if ($r[0] == $value) $return .= " selected";
					$return .= ">" . $r[1] . "</option>";
				}
			}
			
			$return .= "</select>";
		} elseif ($type == "file") {
			$return .= "<input type='file' name='" . $name . "' class='josh_field'>";
			if ($required) $this->valid .= "if (!form." . $name . ".value.length) errors[errors.length] = 'the \'" . strip_tags($message) . "\' field is empty';\n";
		} elseif ($type == "raw") {
			$return .= $value;
		} elseif ($type == "date") {
			$return .= josh_draw_form_date($name, $value);
		} elseif ($type == "datetime") {
			$return .= josh_draw_form_date($name, $value, true);
		}
		$return .= "</td></tr>" . $_josh["newline"] . $_josh["newline"] . $_josh["newline"];
		$this->rows[] = $return;
	}
	function add_hidden($name, $value) {
		$this->rows[] = "<input type='hidden' name='" . $name . "' value='" . $value . "'>";
	}
	function draw($action, $message) {
		global $_josh;
		$_josh["forms"][] = $action;
		$form_num = count($_josh["forms"]);
		$return = josh_draw_css() . josh_draw_javascript();
		if (!$this->context) $this->set_context();
		$this->colspan = ($this->text_orientation == "left") ? 2 : 1;
		$return	.= "
			<script language='javascript'>
				<!--
				josh_posted = false;
				function josh_validate_" . $form_num . "(form) {
					if (josh_posted) return false;
					var errors = new Array();
					" . $this->valid . "
					josh_posted = josh_errors(errors);
					return josh_posted;
				}
				//-->
			</script>	
			<table width='100%' cellpadding='" . $this->cellpadding . "' cellspacing='" . $this->cellspacing . "' border='" . $this->border . "' class='josh_message' align='center' bgcolor='" . $this->color_border . "'>
			<form method='post' action='/' name='form_" . $form_num . "' enctype='multipart/form-data' onsubmit='javascript:return josh_validate_" . $form_num . "(this);'>";
		$return .= ($this->context == "server") ? josh_draw_form_hidden("j", $action) : josh_draw_form_hidden("action", $action);
		if ($this->header) $return .= "<td colspan='" . $this->colspan . "' class='josh_heading' bgcolor='" . $this->color_alt . "'>" . $message . "</td>";
		$join = ($this->text_orientation == "stop") ? "<tr><td height='14'></td></tr>" : "";
		$return .= join($join, $this->rows);
		$return .= "
				<tr>
					<td align='center' bgcolor='" . $this->color_alt . "' height='30' colspan='" . $this->colspan . "'><input type='submit' value='" . $message . "'></td>
				</tr>
			</form>";
		if ($this->autofocus && $this->focus && !$_josh["drawn"]["focus"]) {
			$return .= "
			<script language='javascript'>
				document.form_" . $form_num . "." . $this->focus . ".focus();
			</script>";
			$_josh["drawn"]["focus"] = true;
		}
		$return .= "
			</table>";
		return $return;
	}
	function set_colors($color_background=false, $color_border=false, $color_alt=false) {
		global $_josh;
		$this->color_border		= ($color_border) ? $color_border : $_josh["colors"]["white"];
		$this->color_background	= ($color_background) ? $color_background : $_josh["colors"]["white"];
		$this->color_alt		= ($color_alt) ? $color_alt : $_josh["colors"]["white"];
	}
	function set_context($newcontext=false) {
		global $_josh;
		if ($newcontext) {
			$this->context = $newcontext;
		} elseif (!$this->context) {
			$this->context = $_josh["context"];
		}
	}
	function set_dimensions($width, $height=false) {
		$this->field_width		= $width;
		if (!$height) $height	= round($width / 1.61803399, 0);
		$this->textarea_height	= $height;
	}
	function set_misc($text_orientation="left", $header=false, $autofocus=true) {
		$this->text_orientation	= $text_orientation;
		$this->header			= $header;
		$this->autofocus		= $autofocus;
	}
	function set_tableproperties($cellpadding=3, $cellspacing=1, $border=0) {
		$this->cellpadding		= $cellpadding;
		$this->cellspacing		= $cellspacing;
		$this->border			= $border;
	}
}
?>