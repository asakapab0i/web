<?php
/* OBJECT FUNCTIONS (very much in beta)
 * 
 * the object-instance architectural model is about creating a common set of functions to accommodate any database object
 * currently, there are two major design flaws that it's not my priority to fix:
 *		1) the josh_instances table should be split out into one table for each object type
 *		2) flags are really objects (there ought to be an instances_to_objects table)
 * also i'm playing w the idea that object type names should really just be one word that is intelligently pluralized
 */

function josh_object_action($action, $id=false, $array=false) {
	/*	9/2/2007
	 *	this function is an extension of josh_sys_action.  please see it for more details.
	 */
	global $_josh;
	$redirect = (isset($array["redirect"])) ? $array["redirect"] : false;
	if (($action == "object_view") && $_josh["user"]) {
		$object = josh_object_get(false, $id);
		$page = josh_draw_array($object, false);
		josh_draw_eval("dev", $page);
	} elseif (($action == "object_add") && $_josh["user"]) {
		josh_object_add($array["typeID"], $array);
		$redirect	= $_josh["referrer"]["path_query"];
	} elseif (($action == "object_delete") && $_josh["user"]) {
		josh_object_delete($id);
		$redirect	= $_josh["referrer"]["path_query"];
	} elseif (($action == "object_edit") && $_josh["user"]) {
		$_josh["page"]["title"] = "Edit Object";
		$_josh["page"]["id"] = @$_josh["referrer"]["id"];
		$_josh["page"]["is_private"] = false;
		$orientation = ($_josh["site"]["content_width"] && ($_josh["site"]["content_width"] > 530)) ? "left" : "none";
		$page = josh_object_form(false, $id, false	, $orientation, 502, false, true, true);
		josh_draw_eval("dev", $page);
	} elseif (($action == "object_type") && $_josh["user"]) {
		$object = josh_object_info($id);
		$_josh["page"]["title"] = "Show " . $object["name_plural"];
		$page = josh_object_list($id, "created_on", "ASC", false, true);
		josh_draw_eval("dev", $page);
	} elseif (($action == "object_type_add")  && $_josh["user"]["is_admin"]) {
		$is_private = (isset($array["is_private"])) ? 1 : 0;
		$name_plural = josh_format_pluralize($array["name_singular"]);
		$id = josh_db_query("INSERT INTO josh_objects_types ( name_singular, name_plural, created_by, is_private, is_active ) VALUES ( '{$array["name_singular"]}', '{$name_plural}', {$_josh["user"]["id"]}, {$is_private}, 1 )");
		josh_db_query("INSERT INTO josh_objects_types_to_sites ( object_typeID, siteID ) VALUES ( {$id}, {$_josh["site"]["id"]} )");
		$redirect = "/j/draw_manage/";
	} elseif (($action == "object_type_delete")  && $_josh["user"]["is_admin"]) {
		josh_db_query("UPDATE josh_objects_types SET is_active = 0 WHERE id = " . $id);
		$redirect = "/j/draw_manage/";
	} elseif (($action == "object_type_lock") && $_josh["user"]["is_admin"]) {
		josh_db_query("UPDATE josh_objects_types SET is_private = 1 WHERE id = " . $id);
		$redirect = "/j/draw_manage/";
	} elseif (($action == "object_type_unlock") && $_josh["user"]["is_admin"]) {
		josh_db_query("UPDATE josh_objects_types SET is_private = 0 WHERE id = " . $id);
		$redirect = "/j/draw_manage/";
	} elseif (($action == "object_update") && $_josh["user"]) {
		josh_object_update($array);
		$redirect	= $array["pageURL"];
	}
	//die($redirect);
	return $redirect;
}

function josh_object_add($typeID, $array) {
	/*	9/2/2007
	 *	this takes an array (a POST array, for example) and adds an object/instance pair to the database, returning the newly-created object id
	 */
	global $_josh;
	
	//create object
	$objectID = josh_db_query("INSERT INTO josh_objects ( typeID, is_active, josh_objects.key ) VALUES ( {$typeID}, 1, REPLACE(REPLACE(ENCRYPT(UUID()), '/', '|'), '.', '!') )");
	
	//create instance
	$instanceID = josh_object_instance($typeID, $objectID, $array);
		
	//update object with current instance
	josh_db_query("UPDATE josh_objects SET firstInstanceID = {$instanceID}, currentInstanceID = {$instanceID} WHERE id = {$objectID}");
	
	//update RSS ~ TODO: make RSS global
	if ($typeID == 11) josh_xml_rss_generate();

	return $objectID;
}

function josh_object_delete($objectID) {
	global $_josh;
	josh_db_query("UPDATE josh_objects SET deleted_on = NOW(), deleted_by = {$_josh["user"]["id"]}, is_active = 0 WHERE id = " . $objectID);
	josh_xml_rss_generate(); //because
}

function josh_object_fields($objectTypeID) {
	//returns the fields associated with a particular objectType
	global $_josh;
	if (!isset($_josh["object"][$objectTypeID]["fields"])) {
		$_josh["object"][$objectTypeID]["fields"] = array();
		$result = josh_db_query("SELECT f.id, f.typeID, t.type, f.object_typeID, f.flag_typeID, f.display_name, f.column_name, f.is_required, f.is_admin, f.precedence FROM josh_fields f JOIN josh_fields_types t ON f.typeID = t.id WHERE f.object_typeID = {$objectTypeID} ORDER BY f.precedence");
		while ($r = josh_db_fetch($result)) $_josh["object"][$objectTypeID]["fields"][] = $r;
	}
	return $_josh["object"][$objectTypeID]["fields"];
}

function josh_object_flags_get($typeID, $index=false) {
	/*	9/2/2007
	 *	obsolete?
	 */
	global $_GET;
	if ($index && isset($_GET[$index]) && josh_format_check($_GET[$index])) {
		return josh_db_grab("SELECT f.id, f.name FROM josh_flags f WHERE f.id = {$_GET[$index]} AND f.typeID = {$typeID}");
	} else {
		$return = array();
		$flags = josh_db_query("SELECT f.id, f.name FROM josh_flags f WHERE f.typeID = {$typeID} AND f.is_active = 1 ORDER BY f.precedence");
		while ($f = josh_db_fetch($flags)) $return[] = $f;
		return $return;
	}
}

function josh_object_flags($flag_typeID, $instanceID=false) {
	/*	9/2/2007 - updated 3/14/2008
	 *	returns a list of the flags.  for use in dropdowns, checkboxes, etc.
	 */
	$checked = ($instanceID) ? "(SELECT COUNT(*) FROM josh_instances_to_flags i2f WHERE i2f.flagID = f.id AND i2f.instanceID = " . $instanceID . ")" : "0";
	$flags = josh_db_query("SELECT f.id, f.name, " . $checked . " checked FROM josh_flags f WHERE f.typeID = {$flag_typeID} ORDER BY f.precedence");
	while ($f = josh_db_fetch($flags)) $return[] = $f;
	return $return;
}

function josh_object_form($objectTypeID=false, $objectKey=false, $instanceID=false, $orientation="left", $width=false, $height=false, $header=true, $autofocus=true) {
	global $_josh;
	if (!$_josh["user"]) return false;
	if ($objectTypeID) { //add object
		$object = josh_object_info($objectTypeID);
		$action = "Add New ";
		$action_code = "object_add";
	} elseif ($objectKey) {
		$object = josh_object_get(false, $objectKey, false);
		$action = "Edit ";
		$action_code = "object_update";
		$instanceID = $object["instanceID"];
	} elseif ($instanceID) {
		return false;
		$object = josh_db_grab("SELECT o.typeID, t.name_singular, t.name_plural, t.is_private
			FROM josh_instances i 
			JOIN josh_objects o ON i.objectID = o.id
			JOIN josh_objects_types t ON o.typeID = t.id
			WHERE i.id = " . $instanceID);
		$typeID = $object["typeID"];
	} else {
		return false;
	}
	$form = new josh_draw_table_form;
	$form->set_colors($_josh["colors"]["white"], $_josh["colors"]["grey2"], $_josh["colors"]["grey1"]);
	$form->set_dimensions($width, $height);
	$form->set_misc($orientation, $header, $autofocus);
	$form->set_context("server");
	$form->add_hidden("objectKey",	@$objectKey);
	$form->add_hidden("pageID",		@$_josh["page"]["id"]);
	$form->add_hidden("pageURL",	@$_josh["referrer"]["path_query"]);
	$form->add_hidden("typeID",		$object["typeID"]);
	$fields = josh_object_fields($object["typeID"]);
	foreach($fields as $field) {
		if ($objectKey) {
			if ($field["column_name"]) $value = $object[josh_format_text_code($field["column_name"])];
		} else {
			$value = false;
		}
		if ($field["typeID"] == 1) {
			$form->add_row("text", $field["column_name"], $value, $field["display_name"], false, false, $field["is_required"]);
		} elseif ($field["typeID"] == 2) {
			$form->add_row("textarea", $field["column_name"], $value, $field["display_name"], false, false, $field["is_required"]);
		} elseif ($field["typeID"] == 3) {
			$form->add_row("datetime", $field["column_name"], $value, $field["display_name"], false, false, $field["is_required"]);
		} elseif ($field["typeID"] == 4) { //flag multiple (should some of this be moved to add-row?
			$flags = josh_object_flags($field["flag_typeID"], $instanceID);
			$form->add_row("checkboxes", $field["flag_typeID"], $flags, $field["display_name"]);
		} elseif ($field["typeID"] == 5) { //flag single (dropdown)
			if ($objectKey) $value = $object["flag_" . $field["flag_typeID"] . "_id"];
			$form->add_row("select", "flag_" . $field["flag_typeID"], $value, $field["display_name"], "SELECT id, name FROM josh_flags WHERE typeID = {$field["flag_typeID"]} ORDER BY precedence", false, $field["is_required"]);
			//todo: add flag edit link
		} elseif ($field["typeID"] == 10) { //text - rich
			$form->add_row("textarea-rich", $field["column_name"], @$object[$field["column_name"]], $field["display_name"], false, false, $field["is_required"]);
		} elseif ($field["typeID"] == 11) { //flag single (radio)
			$flags = josh_objects_flags($field["flag_typeID"]);
			$return = '<table cellpadding="0" cellspacing="0" border="0">';
			if ($_josh["user"]) $return = '<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr valign="top" class="reg"><td>' . $return;
			while ($l = josh_db_fetch($flags)) {
				$return .= '<tr class="reg"><td>' . josh_draw_form_radio("flag_" . $field["flag_typeID"], $l["checked"]) . '</td>';
				$return .= '<td>' . $l["name"] . '</td></tr>';
			}
			$return .= '</table>';
			//todo: fix flag edit link
			if ($_josh["user"]) $return .= '</td><td align="right"><!--[ ' . josh_format_link("edit", "object_flag", $field["flag_typeID"]) . ' ]--></td></tr></table>';
			$form->add_row("raw", $field["display_name"], $return);
		} elseif ($field["typeID"] == 12) { //image
			$form->add_row("file", $field["column_name"], false, $field["display_name"], false, false, $field["is_required"]);
		}
	}
	return $form->draw($action_code, $action . $object["name_singular"]);
}

function josh_object_get($objectTypeID=false, $objectKey=false, $return_display_name=true, $orderBy="created_on", $direction="DESC", $limit=false, $showDeleted=false) {
	if (josh_format_check($objectTypeID)) {
		$object["typeID"] = $objectTypeID;
	} elseif (josh_format_check($objectKey, "key")) {
		$object = josh_object_info(false, $objectKey);
	} else {
		return false;
	}
	$fields = josh_object_fields($object["typeID"]);
	foreach ($fields as $field) {
		$display_name = josh_format_text_code($field["display_name"]);
		if ($field["type"] == "flag_single") {
			$field_name		= "flag_" . $field["flag_typeID"];
			$display_name	= josh_format_text_code($field["display_name"]);
			if (!$return_display_name) $display_name = $field_name;
			if (!$objectKey && stristr($orderBy, $field_name)) $orderBy = str_replace($field_name, $field_name . "_precedence", strToLower($orderBy));
			$array = array("typeID"=>$field["flag_typeID"], "display_name"=>$display_name);
			$flags_group[] = $array;
		} elseif ($field["type"] == "flag_multiple") {
			//todo
		} else {
			if (!$return_display_name) $display_name = $field["column_name"];
			$columns_group[] = "i_current." . $field["column_name"] . " " . $display_name;
			if (!$objectKey && stristr($orderBy, $field["column_name"])) $orderBy = str_replace($field["column_name"], "i_current." . $field["column_name"], strToLower($orderBy));
		}
	}
	
	//add flags
	$flag_select = "";
	if (isset($flags_group)) {
		foreach ($flags_group as $flag) {
			$flag_select .= ", (SELECT f" . $flag["typeID"] . ".name		FROM josh_flags f" . $flag["typeID"] . " INNER JOIN josh_instances_to_flags i2f" . $flag["typeID"] . " ON i2f" . $flag["typeID"] . ".flagID = f" . $flag["typeID"] . ".id WHERE i2f" . $flag["typeID"] . ".instanceID = i_current.id AND f" . $flag["typeID"] . ".typeID = " . $flag["typeID"] . ") as flag_{$flag["typeID"]} ";
			$flag_select .= ", (SELECT f" . $flag["typeID"] . ".id			FROM josh_flags f" . $flag["typeID"] . " INNER JOIN josh_instances_to_flags i2f" . $flag["typeID"] . " ON i2f" . $flag["typeID"] . ".flagID = f" . $flag["typeID"] . ".id WHERE i2f" . $flag["typeID"] . ".instanceID = i_current.id AND f" . $flag["typeID"] . ".typeID = " . $flag["typeID"] . ") as flag_{$flag["typeID"]}_id  ";
			$flag_select .= ", (SELECT f" . $flag["typeID"] . ".precedence	FROM josh_flags f" . $flag["typeID"] . " INNER JOIN josh_instances_to_flags i2f" . $flag["typeID"] . " ON i2f" . $flag["typeID"] . ".flagID = f" . $flag["typeID"] . ".id WHERE i2f" . $flag["typeID"] . ".instanceID = i_current.id AND f" . $flag["typeID"] . ".typeID = " . $flag["typeID"] . ") as flag_{$flag["typeID"]}_precedence ";
		}
	}
	
	//add columns
	$columns_group = (isset($columns_group)) ? join(", ", $columns_group) . "," : "";
	
	//additional parameters
	if ($objectKey) {
		$where = "o.key = '" . $objectKey . "'";
		$limit = "";
		$orderBy = "";
		$direction = "";
	} else {
		$where = "o.typeID = " . $object["typeID"];	
		if (!$showDeleted) $where .= " AND o.is_active = 1";
		$limit = ($limit) ? " LIMIT " . $limit : "";
		$orderBy = " ORDER BY " . $orderBy . " ";
	}

	$result = josh_db_query("SELECT
						o.id,
						o.firstInstanceID,
						o.currentInstanceID,
						o.key,
						i_first.created_on as created_on,
						u_first.name created_by,
						i_first.created_by created_by_id,
						" . $columns_group . " 
						(SELECT COUNT(*) FROM josh_instances i WHERE i.objectID = o.id) count_updated,
						i_current.created_on as updated_on,
						u_current.name updated_by,
						i_current.created_by created_by_id
						" . $flag_select . ",
						o.is_active,
						o.deleted_on,
						o.deleted_by deleted_by_id
						FROM josh_objects o 
						JOIN josh_instances i_first ON o.firstInstanceID   = i_first.id
						JOIN josh_instances i_current ON o.currentInstanceID = i_current.id
						JOIN josh_users u_first ON i_first.created_by = u_first.id
						JOIN josh_users u_current ON i_current.created_by = u_current.id
						LEFT JOIN josh_users u_deleted ON o.deleted_by = u_deleted.id
						WHERE " . $where . $orderBy . $direction . $limit);
	
	if (!josh_db_found($result)) return false;
	if ($objectKey) {
		$return = josh_db_fetch($result);
		return array_merge($return, $object);
	} else {
		$objects = array();
		while ($r = josh_db_fetch($result)) $objects[] = $r;
		return $objects;
	}
}

function josh_object_get_flags($typeID, $key, $withID=true) {
	/*
	used by rock dove provider page
	*/
	global $_josh;
	$flags = josh_db_query("SELECT 
		f.id,
		f.name
	FROM josh_flags f
	JOIN josh_instances_to_flags i2f ON f.id = i2f.flagID
	JOIN josh_objects o ON i2f.instanceID = o.currentInstanceID
	WHERE o.key = '$key' AND f.typeID = $typeID
	ORDER BY f.precedence");
	if (josh_db_found($flags)) {
		while ($f = josh_db_fetch($flags)) {
			$return[] = ($withID) ? $f : $f["name"];
		}
		return $return;
	} else {
		return false;
	}
}

function josh_object_get_flagged($objectTypeID, $flagID, $orderBy="created_on", $direction="DESC", $limit=false, $showDeleted=false) {
	$object["typeID"] = $objectTypeID;
	$fields = josh_object_fields($object["typeID"]);
	foreach ($fields as $field) {
		$display_name = josh_format_text_code($field["display_name"]);
		if ($field["type"] == "flag_single") {
			$field_name		= "flag_" . $field["flag_typeID"];
			if ($orderBy == $display_name) $orderBy = $field_name . "_precedence";
			$flags_group[] = array("typeID"=>$field["flag_typeID"], "display_name"=>$display_name);
		} elseif ($field["type"] == "flag_multiple") {
			//todo
		} else {
			$columns_group[] = "i_current." . $field["column_name"] . " " . $display_name;
			if ($orderBy == $display_name) $orderBy = "i_current." . $field["column_name"];
		}
	}
	
	//add flags
	$flag_select = "";
	if (isset($flags_group)) {
		foreach ($flags_group as $flag) {
			$flag_select .= ", (SELECT f" . $flag["typeID"] . ".name		FROM josh_flags f" . $flag["typeID"] . " INNER JOIN josh_instances_to_flags i2f" . $flag["typeID"] . " ON i2f" . $flag["typeID"] . ".flagID = f" . $flag["typeID"] . ".id WHERE i2f" . $flag["typeID"] . ".instanceID = i_current.id AND f" . $flag["typeID"] . ".typeID = " . $flag["typeID"] . ") as flag_{$flag["typeID"]} ";
			$flag_select .= ", (SELECT f" . $flag["typeID"] . ".id			FROM josh_flags f" . $flag["typeID"] . " INNER JOIN josh_instances_to_flags i2f" . $flag["typeID"] . " ON i2f" . $flag["typeID"] . ".flagID = f" . $flag["typeID"] . ".id WHERE i2f" . $flag["typeID"] . ".instanceID = i_current.id AND f" . $flag["typeID"] . ".typeID = " . $flag["typeID"] . ") as flag_{$flag["typeID"]}_id  ";
			$flag_select .= ", (SELECT f" . $flag["typeID"] . ".precedence	FROM josh_flags f" . $flag["typeID"] . " INNER JOIN josh_instances_to_flags i2f" . $flag["typeID"] . " ON i2f" . $flag["typeID"] . ".flagID = f" . $flag["typeID"] . ".id WHERE i2f" . $flag["typeID"] . ".instanceID = i_current.id AND f" . $flag["typeID"] . ".typeID = " . $flag["typeID"] . ") as flag_{$flag["typeID"]}_precedence ";
		}
	}
	
	//add columns
	$columns_group = (isset($columns_group)) ? join(", ", $columns_group) . "," : "";
	
	//additional parameters
	$where = "o.typeID = " . $object["typeID"] . " AND (SELECT COUNT(*) FROM josh_instances_to_flags i2f WHERE i2f.flagID = {$flagID} AND i2f.instanceID = o.currentInstanceID) > 0";
	if (!$showDeleted) $where .= " AND o.is_active = 1";
	$limit = ($limit) ? " LIMIT " . $limit : "";
	$orderBy = " ORDER BY " . $orderBy . " ";

	$result = josh_db_query("SELECT
						o.id,
						o.firstInstanceID,
						o.currentInstanceID,
						o.key,
						i_first.created_on as created_on,
						u_first.name created_by,
						i_first.created_by created_by_id,
						" . $columns_group . " 
						(SELECT COUNT(*) FROM josh_instances i WHERE i.objectID = o.id) count_updated,
						i_current.created_on as updated_on,
						u_current.name updated_by,
						i_current.created_by created_by_id
						" . $flag_select . ",
						o.is_active,
						o.deleted_on,
						o.deleted_by deleted_by_id
						FROM josh_objects o 
						JOIN josh_instances i_first ON o.firstInstanceID   = i_first.id
						JOIN josh_instances i_current ON o.currentInstanceID = i_current.id
						JOIN josh_users u_first ON i_first.created_by = u_first.id
						JOIN josh_users u_current ON i_current.created_by = u_current.id
						LEFT JOIN josh_users u_deleted ON o.deleted_by = u_deleted.id
						WHERE " . $where . $orderBy . $direction . $limit);
	
	if (!josh_db_found($result)) return false;
	$objects = array();
	while ($r = josh_db_fetch($result)) $objects[] = $r;
	return $objects;
}

function josh_object_info($objectTypeID=false, $objectKey=false) {
	/*	9/12/2007
	 *	this function grabs like the 'header' of the object.  like doing 'get info' in the finder.  returns basic info like name
	 *	when all you know is the key
	 */
	global $_josh;
	if ($objectTypeID) {
		//trying to prevent unnecessary trips to the database -- storing info in array
		if (!isset($_josh["object"][$objectTypeID]["info"])) {
			$_josh["object"][$objectTypeID]["info"] = josh_db_grab("SELECT t.id typeID, t.name_singular, t.name_plural, t.is_private FROM josh_objects_types t WHERE t.id = " . $objectTypeID);
		}
		return $_josh["object"][$objectTypeID]["info"];
	} elseif ($objectKey) {
		$result = josh_db_grab("SELECT o.id, o.typeID, o.currentInstanceID instanceID, t.name_singular, t.name_plural, t.is_private FROM josh_objects_types t JOIN josh_objects o ON o.typeID = t.id WHERE o.key = '" . $objectKey . "'");
		$_josh["object"][$result["typeID"]]["info"] = $result;
		return $_josh["object"][$result["typeID"]]["info"];
	} else {
		return false;
	}
}

function josh_object_instance($typeID, $objectID, $array) {
	global $_josh;
	
	//get fields
	$fields = josh_object_fields($typeID);
	$flag_m = array();
	$flag_s = array();
	foreach ($fields as $field) {
		if ($field["type"] == "datetime") {
			$columns[] = $field["column_name"];
			$values[] = josh_format_date_sql($field["column_name"]);
		} elseif ($field["type"] == "flag_single") {
			$flag_s[] = $field["flag_typeID"];
		} elseif ($field["type"] == "flag_multiple") {
			$flag_m[] = $field["flag_typeID"];
		} elseif ($field["type"] == "mediumblob") {
			$filename = $_FILES[$field["column_name"]]["tmp_name"];
			if (file_exists($filename)) {
				$columns[] = $field["column_name"];
				$values[] = josh_format_binary(file_get_contents($filename));
				unlink($filename);
			}
		} else {
			$columns[] = $field["column_name"];
			$values[]  = "'" . $array[$field["column_name"]] . "'";
		}
	}
	$column_group = join(", ", $columns);
	$values_group = join(", ", $values);
	
	//create instance
	$instanceID = josh_db_query("INSERT INTO josh_instances (
				objectID,
				{$column_group},
				created_on,
				created_by
			) VALUES (
				{$objectID},
				{$values_group},
				NOW(),
				{$_josh["user"]["id"]}
			)");
	
	//search index
	josh_object_words_update($instanceID);
	
	//single flags
	reset($flag_s);
	foreach ($flag_s as $flagType) {
		if ($array["flag_" . $flagType]) josh_db_query("INSERT INTO josh_instances_to_flags ( instanceID, flagID ) VALUES ( {$instanceID}, {$array["flag_" . $flagType]} )");
	}
	
	//multiple flags
	reset($flag_m);
	foreach ($flag_m as $flagType) {
		reset($array);
		while (list($key, $value) = each($array)) {
			if (josh_format_text_starts("flag_" . $flagType, $key)) {
				$flagID = str_replace("flag_" . $flagType . "_", "", $key);
				josh_db_query("INSERT INTO josh_instances_to_flags ( instanceID, flagID ) VALUES ( {$instanceID}, {$flagID} )");
			}
		}
	}
	
	return $instanceID;
}

function josh_object_list($typeID, $orderBy="created_on", $direction="DESC", $limit=false, $header=false, $showDeleted=false, $groupBy=false, $addNew=true) {
	global $_josh;
	if (!josh_format_check($typeID)) return false;
	$object = josh_object_info($typeID);
	$return = '<table width="100%" cellpadding="3" cellspacing="1" border="0" bgcolor="' . $_josh["colors"]["grey2"] . '">';
	if ($header)  {
		$return .= "<tr bgcolor='" . $_josh["colors"]["grey1"] . "' class='josh_heading_large'><td align='left' colspan='4'>" . $object["name_plural"] . "</td></tr>";
		$return .= "<tr bgcolor='" . $_josh["colors"]["grey1"] . "' class='josh_smaller'>
			<td width='60%'>Name</td>
			<td width='20%' align='right'>Last Updated</td>
			<td width='20%' align='right'>By</td>
			<td width='16'></td>
		</tr>";
	}
	if ($groupBy) $orderBy = $groupBy . ", " . $orderBy;
	$objects = josh_object_get($typeID, false, true, $orderBy, $direction, $limit, $showDeleted);
	if ($objects) {
		if ($groupBy) $lastGroup = "";
		foreach ($objects as $o) {
			//$return .= josh_draw_array($o, false);
			if ($groupBy && ($o[$groupBy] != $lastGroup)) $return .= '<tr class="reg"><td bgcolor="' . $_josh["colors"]["grey1"] . '" height="40" valign="bottom" colspan="3"><b>' . josh_format_text_human($o[$groupBy]) . '</b></td></tr>';
			$class = ($o["is_active"]) ? "reg" : "reg-deleted";
			$return .= '<tr class="' . $class . '" bgcolor="' . $_josh["colors"]["white"] . '">';
			
			if ($o["is_active"]) {
				$return .= '<td>' . josh_format_link($o["name"], "object_edit", $o["key"]) . '</td>';
			} else {
				$return .= '<td>' . $o["name"] . '</td>';
			}
			$return .= '<td align="right">' . josh_format_date($o["updated_on"]) . '</td>';
			$return .= '<td align="right">' . ucwords($o["updated_by"]) . '</td>';
			$return .= '<td>' . josh_format_link("icon_delete", "object_delete", $o["id"]) . '</td></tr>';
			if ($groupBy) $lastGroup = $o[$groupBy];
		}
	} else {
		$return .= "<tr><td height='200' bgcolor='" . $_josh["colors"]["grey1"] . "' align='center' colspan='4' class='josh_message'>No objects</td></tr>";
	}
	$return .= "</table><br>";
	if ($addNew) $return .= josh_object_form($typeID, false, false, "left", 502, false, true, false) . "<br>";
	return $return;
}

function josh_object_security($objectTypeID) {
	global $_josh;
	$object = josh_object_info($objectTypeID);
	if (!$object["is_private"] && !$_josh["user"]) return false;
	return true;
}

function josh_object_types_get() {
	global $_josh;
	return josh_db_query("SELECT t.id, t.name_singular, t.name_plural, t.is_private, (SELECT COUNT(*) FROM josh_objects o WHERE o.typeID = t.id AND o.is_active = 1) num_objects FROM josh_objects_types t JOIN josh_objects_types_to_sites ot2s ON t.id = ot2s.object_typeID WHERE ot2s.siteID = {$_josh["site"]["id"]} ORDER BY name_plural");
}


function josh_object_update($array) {
	/*	9/12/2007
	 *	certainly some elements of this can be combined with josh_object_add
	 *	switching to keys, which is making things ugly
	 */
	global $_josh;
	if (empty($array["objectKey"])) return false;
	
	//get object info
	$object = josh_object_info(false, $array["objectKey"]);
	
	//create new instance
	$instanceID = josh_object_instance($object["typeID"], $object["id"], $array);
	
	//update object with current instance
	josh_db_query("UPDATE josh_objects SET currentInstanceID = {$instanceID} WHERE id = " . $object["id"]);
	
	//update blog RSS ~ TODO: make RSS generalized to all object types
	//it's really a naming question.  having the one-word object names will help with this, eg /joshserver/rss/posts.xml, /joshserver/rss/providers.xml
	if ($object["typeID"] == 11) josh_xml_rss_generate();
	
	return $object["typeID"];
}

function josh_object_words_update($instanceID) {
	global $_josh;
	$text	= josh_db_grab("SELECT i.varchar_1 + ' ' + i.varchar_2 + ' ' + i.varchar_3 + ' ' + i.text_1 + ' ' + i.text_2 + ' ' + i.text_3 FROM josh_instances i WHERE i.id = " . $instanceID);
	$words	= array_diff(split("[^[:alpha:]]+", strtolower(strip_tags($text))), $_josh["ignored_words"]);
	foreach ($words as $word) {
		$wordID = josh_db_grab("SELECT id FROM josh_words WHERE word = '{$word}'");
		if (!$wordID) $wordID = josh_db_query("INSERT INTO josh_words ( word ) VALUES ( '{$word}' )");
		$occurrences = josh_db_grab("SELECT occurrences FROM josh_instances_to_words WHERE wordID = {$wordID} AND instanceID = " . $instanceID);
		if ($occurrences) {
			josh_db_query("UPDATE josh_instances_to_words SET occurrences = " . ++$occurrences . " WHERE wordID = {$wordID} AND instanceID = " . $instanceID);
		} else {
			josh_db_query("INSERT INTO josh_instances_to_words ( instanceID, wordID, occurrences ) VALUES ( {$instanceID}, {$wordID}, 1 )");
		}
	}                      
}
?>