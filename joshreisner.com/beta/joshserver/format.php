<?php
//format functions

function josh_format_binary($blob) {
	return "'" . addslashes($blob) . "'";
}

function josh_format_boolean($value, $pattern="Yes|No") {
	list($yes, $no) = explode("|", $pattern);
	return ($value) ? $yes : $no;
}

function josh_format_check($variable, $type="int") {
	if ($type == "int") {
		if (!is_numeric($variable)) return false;
	} elseif ($type == "key") {
		if (strlen($variable) > 13) return false;
	}
	return true;
}

function josh_format_code($code) {
	return "<div class='josh_code'>" . nl2br(str_replace("\t", "&nbsp;", $code)) . "</div>";
}

function josh_format_date($timestamp, $error="N/A", $format="M d, Y") {
	global $_josh;

	//reject or convert
	if (empty($timestamp) || ($timestamp == "Jan 1 1900 12:00AM")) return $error;
	if (!is_int($timestamp)) $timestamp = strToTime($timestamp);
	
	//get timestamp for today
	$todaysdate = mktime(0, 0, 1, $_josh["month"], $_josh["today"], $_josh["year"]);

	//get timestamp for argument, without time
	$returnday    = date("d", $timestamp);
	$returnyear   = date("Y", $timestamp);
	$returnmonth  = date("n", $timestamp);
	$returndate   = mktime(0, 0, 1, $returnmonth, $returnday, $returnyear);
	
	//setup return date
	if ($todaysdate == $returndate) {
		$return = "Today";
	} elseif (($todaysdate - 86400) == $returndate) {
		$return = "Yesterday";
	} elseif (($todaysdate + 86400) == $returndate) {
		$return = "Tomorrow";
	} else {
		$return = "<nobr>" . date($format, $timestamp) . "</nobr>";
	}
	return $return;
}

function josh_format_date_iso8601($timestamp=false) {
	if (!$timestamp) $timestamp = time();
	if (!is_int($timestamp)) $timestamp = strToTime($timestamp);
	return date("Y-m-d", $timestamp) . "T" . date("H:i:s", $timestamp) . "-07:00";
}

function josh_format_date_sql($str) {
	global $_POST;
	
	$month  = $_POST[$str . "Month"];
	$day    = $_POST[$str . "Day"];
	$year   = $_POST[$str . "Year"];
	
	$hour   = isset($_POST[$str . "Hour"])   ? $_POST[$str . "Hour"]   : 0;
	$minute = isset($_POST[$str . "Minute"]) ? $_POST[$str . "Minute"] : 0;
	$second = isset($_POST[$str . "Second"]) ? $_POST[$str . "Second"] : 0;
	
	if (isset($_POST[$str . "AMPM"])) {
		if ($_POST[$str . "AMPM"] == "AM") {
			if ($hour == 12) $hour = 0;
		} else {
			if ($hour != 12) $hour +=12;
		}
	}
	
	if (!empty($month) && !empty($day) && !empty($year)) {
		return "'" . date("Y-m-d H:i:00", mktime($hour,$minute,$second,$month,$day,$year)) . "'";
	} else {
		return "NULL";
	}
}

function josh_format_date_time($timestamp, $error="N/A", $separator="&nbsp;") {
	$return = josh_format_date($timestamp, $error);
	if (($return == "Today") || ($return == "Yesterday") || ($return == "Tomorrow")) $return = josh_format_time($timestamp) . $separator . $return;
	return $return;
}

function josh_format_email($address) {
	//simple patch to prevent email form hijacking
	$address = preg_replace("/\r/", "", $address);
	$address = preg_replace("/\n/", "", $address);
	return $address;
}

function josh_format_esc($value) {
	if (is_string($value)) {
		$value = str_replace("'", "''", $value);
		$value = str_replace("\''", "''", $value);
	}
	return $value;
}

function josh_format_link($text, $action, $param=false, $class="josh_dark", $external=false) {
	if ($text == "icon_moveup")	{
		$text = "<img src='/joshserver/images/icons/moveup_off.gif' width='16' height='16' border='0'>";
	} elseif ($text == "icon_movedown") {
		$text = "<img src='/joshserver/images/icons/movedown_off.gif' width='16' height='16' border='0'>";
	} elseif ($text == "icon_moveleft") {
		$text = "<img src='/joshserver/images/icons/moveleft_off.gif' width='16' height='16' border='0'>";
	} elseif ($text == "icon_moveright") {
		$text = "<img src='/joshserver/images/icons/moveright_off.gif' width='16' height='16' border='0'>";
	} elseif ($text == "icon_lock") {
		$text = "<img src='/joshserver/images/icons/lock_off.gif' width='16' height='16' border='0'>";
	} elseif ($text == "icon_delete") {
		$text = "<img src='/joshserver/images/icons/delete_off.gif' width='16' height='16' border='0'>";
	} elseif ($text == "spacer") {
		$text = josh_draw_spacer(16, 16);
	}
	$return = "<a href='";
	$return .= ($external) ? "http://" : "/j/";
	$return .= $action . "/";
	if ($param) $return .= $param . "/";
	$return .= "' class='" . $class . "'>" . $text . "</a>";
	return $return;
}

function josh_format_text_code($str) {
	$return = strToLower($str);
	$return = str_replace("/",	"_",	$return);
	$return = str_replace(" ",	"_",	$return);
	$return = str_replace("&",	"and",	$return);
	return $return;
}

function josh_format_text_human($str, $convertdashes=true) {
	$return = str_replace("_", " ", strToLower($str));
	if ($convertdashes) $return = str_replace("-", " ", $return);
	return josh_format_title($return);
}

function josh_format_title($str) {
	return ucwords($str);
}

function josh_format_pluralize($entity) {
	$length = strlen($entity);
	if (substr($entity, -1) == "y") {
		return substr($entity, 0, ($length - 1)) . "ies";
	} else {
		return $entity . "s";
	}
}

function josh_format_quantitize($quantity, $entity) {
	global $_josh;
	if ($quantity == 0) {
		return "no " . josh_format_pluralize($entity);
	} elseif ($quantity == 1) {
		return "one " . $entity;
	} elseif ($quantity < 10) {
		return $_josh["numbers"][$quantity] . " " . josh_format_pluralize($entity);
	} else {
		return $quantity . " " . josh_format_pluralize($entity);
	}

}

function josh_format_text_shorten($text, $length, $append="&#8230;", $appendlength=1) {
	if ($append) $length = $length - $appendlength;
	if (strlen($text) > $length) return substr($text, 0, $length) . $append;
	return $text;
}

function josh_format_text_starts($needle, $haystack) {
	if (strToLower(substr($haystack, 0, strlen($needle))) == strToLower($needle)) return true;
	return false;
}

function josh_format_time($timestamp, $error="") {
	if (empty($timestamp) || ($timestamp == "Jan 1 1900 12:00AM")) return $error;
	if (!is_int($timestamp)) $timestamp = strToTime($timestamp);
	return date("g:ia", $timestamp);
}

function josh_format_times($num) {
	global $_josh;
	if ($num == 1) {
		return "once";
	} elseif ($num == 2) {
		return "twice";
	} elseif ($num < 10) {
		return $_josh["numbers"][$num] . " times";
	} else {
		return number_format($num) . " times";
	}
}

function josh_format_unesc($value) {
	if (is_string($value)) return str_replace("''", "'", $value);
	return $value;
}
?>