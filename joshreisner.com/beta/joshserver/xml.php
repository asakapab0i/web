<?php
//xml functions
function josh_xml_backup_generate() {
	global $_josh;
	$nodes["site"] = array("post_live", "post_dev", "css_live", "css_dev", "header_live", "header_dev", "footer_live", "footer_dev");
	$nodes["page"] = array("content_live", "content_dev", "title", "folder");

	$return  = '<?xml version="1.0" encoding="UTF-8"?>' . $_josh["newline"];
	$return .= '<site xmlns="http://' . $_josh["website"] . '/documentation/schemas/site/" save_date="' . josh_format_date_iso8601() . '">' . $_josh["newline"];
	foreach ($nodes["site"] as $node) $return .= josh_xml_node($node, $_josh["site"][$node]);

	$parents = josh_db_query("SELECT id, folder, title, content_live, content_dev FROM josh_pages WHERE siteID = {$_josh["site"]["id"]} AND parentID IS NULL ORDER BY sequence");
	while ($parent = josh_db_fetch($parents)) {
		$return .= '	<parent>';
		foreach ($nodes["page"] as $node) $return .= josh_xml_node($node, $parent[$node]);
		$children = josh_db_query("SELECT folder, title, content_live, content_dev FROM josh_pages WHERE parentID = {$parent["id"]} ORDER BY sequence");
		while ($child = josh_db_fetch($children)) {
			$return .= '		<child>';
			foreach ($nodes["page"] as $node) $return .= josh_xml_node($node, $child[$node]);
			$return .= '		</child>' . $_josh["newline"];
		}
		$return .= '</parent>' . $_josh["newline"];
	}
	$return .= '</site>';
	
	//todo ~ make output function
	if (ereg('Opera(/| )([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT'])) {
		$browser = "Opera";
	} elseif (ereg('MSIE ([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT'])) {
		$browser = "IE";
	} else {
		$browser = '';
	}
	$mime_type = ($browser == 'IE' || $browser == 'Opera') ? 'application/octetstream' : 'application/octet-stream';
	header('Content-Type: ' . $mime_type);
	header('Content-Disposition: attachment; filename="' . $_josh["site"]["url"] . ' (' . $_josh["year"] . '-' . sprintf("%02d", $_josh["month"]) . '-' . sprintf("%02d", $_josh["today"]) . ').xml"');
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header('Accept-Ranges: bytes');
	header("Cache-control: private");
	header('Pragma: private');
	echo utf8_encode($return);
}

function josh_xml_escape($html) {
	global $_josh;
	return str_replace($_josh["newline"], "&#13;", htmlentities($html));
}

function josh_xml_import($siteID) {
	global $_FILES;
	$xml = new josh_xml_import;
	$xml->parse($_FILES["file"]["tmp_name"]);
	$xml->import($siteID);
	unlink($_FILES["file"]["tmp_name"]);
}

function josh_xml_node($node, $value) {
	global $_josh;
	return "<" . $node . ">" . josh_xml_escape($value) . "</" . $node . ">" . $_josh["newline"];
}

function josh_xml_unescape($cdata) {
	global $_josh;
	return josh_format_esc(str_replace("&#13;", $_josh["newline"], html_entity_decode($cdata)));
}

class josh_xml_import {
	var $parser;
	var $tag;
	var $index = -1;
	var $child = -1;
	var $children = false;
	var $site  = array("post"=>"", "css"=>"", "header"=>"", "footer"=>"");
	var $pages = array();
	
	function start($parser, $name, $attributes) {
		if ($this->tag == "parent") {
			$this->index++;
			$this->children = false;
			$this->child = -1;
		} elseif ($this->tag == "child") {
			$this->children = true;
			$this->child++;
		}
		$this->tag = strToLower($name);
		if (count($attributes)) {
			foreach ($attributes as $key => $value) {
				//don't need to do anything with the tag attributes, leaving code just in case
			}
		}
	}
	
	function stop($parser, $name) {
		$this->tag = "";
	}
	
	function cdata($parser, $data) {
		if (($this->tag == "post_live") || ($this->tag == "post_dev") || ($this->tag == "header_live") || ($this->tag == "header_dev") || ($this->tag == "css_live") || ($this->tag == "css_dev") || ($this->tag == "footer_live") || ($this->tag == "footer_dev")) {
			if (empty($this->site[$this->tag])) {
				$this->site[$this->tag] = josh_xml_unescape($data);
			} else {
				$this->site[$this->tag] .= josh_xml_unescape($data);
			}
		} elseif ($this->tag == "folder") {
			if ($this->children) {
				$this->pages[$this->index]["children"][$this->child]["folder"] = josh_format_esc(rawurldecode($data));
			} else {
				$this->pages[$this->index]["folder"] = josh_format_esc(rawurldecode($data));
			}
		} elseif (($this->tag == "title") || ($this->tag == "content_live") || ($this->tag == "content_dev")) {
			$data = josh_xml_unescape($data);
			if ($this->children) {
				if (empty($this->pages[$this->index]["children"][$this->child][$this->tag])) {
					$this->pages[$this->index]["children"][$this->child][$this->tag] = $data;
				} else {
					$this->pages[$this->index]["children"][$this->child][$this->tag] .= $data;
				}
			} else {
				if (empty($this->pages[$this->index][$this->tag])) {
					$this->pages[$this->index][$this->tag] = $data;
				} else {
					$this->pages[$this->index][$this->tag] .= $data;
				}
			}
		}
	}
	
	function parse($file) {
		global $_josh;
		josh_sys_debug("starting xml parser");
		$this->parser = xml_parser_create();
		xml_set_object($this->parser, $this);
		xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, 1);
		xml_set_element_handler($this->parser, "start", "stop");
		xml_set_character_data_handler($this->parser, "cdata");
		$data = josh_sys_file_get($file);
		
		//clean up xml input
		$data = str_replace("&raquo;", "&#187;", $data); //xml parse hates raquo for some reason ("Undeclared entity error")
		
		if (!xml_parse($this->parser, $data)) {
			if (isset($_josh["site"]["id"])) {
				josh_db_query("DELETE FROM josh_sites WHERE id = " . $_josh["site"]["id"]);
				josh_sys_debug("error parsing ~ site id was " . $_josh["site"]["id"]);
			} else {
				josh_sys_debug("error parsing ~ no site id");
			}
			$message = "joshserver encountered an '" . xml_error_string(xml_get_error_code($this->parser)) . "' parsing your XML file on line " . xml_get_current_line_number($this->parser) . ".  if joshserver created the file you're trying to upload, please " . josh_format_link("report this error", $_josh["website"] . "/help", false, "josh_dark", true) . " to get assistance.  in the meantime, you can also <a href='/' class='josh_dark'>try again</a>.";
			josh_draw_page("error importing file", $message, true);
		}
		xml_parser_free($this->parser);
	}
	
	function import($siteID) {
		global $_josh;
		josh_db_query("UPDATE josh_sites SET post_live = '{$this->site["post_live"]}', post_dev = '{$this->site["post_dev"]}', css_live = '{$this->site["css_live"]}', css_dev = '{$this->site["css_dev"]}', header_live = '{$this->site["header_live"]}', header_dev = '{$this->site["header_dev"]}', footer_live = '{$this->site["footer_live"]}', footer_dev = '{$this->site["footer_dev"]}' WHERE id = " . $siteID);
		$sequence = 0;
		foreach ($this->pages as $page) {
			$page["folder"] = (isset($page["folder"])) ? "'" . $page["folder"] . "'" : "NULL";
			$pageID = josh_db_query("INSERT INTO josh_pages ( siteID, parentID, folder, sequence, title, content_live, content_dev, created_on, created_by ) VALUES ( {$siteID}, NULL, {$page["folder"]}, " . ++$sequence . ", '{$page["title"]}', '" . @$page["content_live"] . "', '" . @$page["content_dev"] . "', NOW(), {$_josh["user"]["id"]} )");
			if (isset($page["children"])) {
				$childsequence = 0;
				foreach ($page["children"] as $child) {
					$child["folder"] = ($child["folder"]) ? "'" . $child["folder"] . "'" : "NULL";
					$childID = josh_db_query("INSERT INTO josh_pages ( siteID, parentID, folder, sequence, title, content_live, content_dev, created_on, created_by ) VALUES ( {$siteID}, {$pageID}, {$child["folder"]}, " . ++$childsequence . ", '{$child["title"]}', '" . @$child["content_live"] . "', '" . @$child["content_dev"] . "', NOW(), {$_josh["user"]["id"]} )");
				}
			}
		}
	}
}

function josh_xml_rss_generate() {
	$return  = '<?xml version="1.0" ?><rss version="2.0"><channel><title>josh reisner dot com</title>';
	$return .=  "<description>This blog is about art, music and technology. It's also part of an experimental web site I'm working on.</description>";
	$return .= '<link>http://joshreisner.com/</link>';
	$objects = josh_db_query("SELECT o.key, i.varchar_1, i.text_1, i.datetime_1 FROM josh_objects o JOIN josh_instances i ON o.currentInstanceID = i.id WHERE o.typeID = 11 AND o.is_active = 1 ORDER BY i.datetime_1 DESC LIMIT 7");
	while ($o = josh_db_fetch($objects)) {
		//make links absolute for remote rss readers
		$o["text_1"] = str_replace('<img src="/', '<img src="http://joshreisner.com/', $o["text_1"]);
		$o["text_1"] = str_replace('<a href="/', '<a href="http://joshreisner.com/', $o["text_1"]);
		//generate entry
		$return .= '<item><title>' . htmlentities($o["varchar_1"]) . '</title>';
		$return .= '<description>' . htmlentities($o["text_1"]) . '</description>';
		$return .= '<pubDate>' . josh_format_date_iso8601($o["datetime_1"]) . '</pubDate>';
		//$return .= '<author>Josh</author>';
		$return .= '<guid isPermaLink="true">http://joshreisner.com/posts/' . $o["key"] . '/</guid>';
		$return .= '<link>http://joshreisner.com/posts/' . $o["key"] . '/</link></item>';
	}
	$return .= '</channel></rss>';
	josh_sys_file_put("rss.xml", $return);
}

function josh_xml_sitemap() {
	global $_josh;
	if (isset($_josh["site"]["id"])) {
		$pages = josh_db_query("SELECT parentID, folder, content_live, created_on, approved_on, sequence, num_updates FROM josh_pages WHERE siteID = {$_josh["site"]["id"]} ORDER BY sequence");
		if (josh_db_found($pages)) {
			$return = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">';
			while ($p = josh_db_fetch($pages)) {
				//priority algorithm; it defines the front page as max priority and all the others descend by 1 thereafter.  this may not make the most sense.  eg shouldn't later parent pages have more priority than earlier child pages?
				$priority = 10 - $p["sequence"];
				if (!$p["parentID"]) $priority++;
				if ($priority < 1) $priority = 1;
				//changefreq algorithm; it determines how often the page is updated by dividing the age of the page by the number of updates.
				$changefreq = (time() - strToTime($p["created_on"])) / $p["num_updates"];
				if ($changefreq < 3600) {
					$changefreq = "hourly";
				} elseif ($changefreq < 86400) {
					$changefreq = "daily";
				} elseif ($changefreq < 604800) {
					$changefreq = "weekly";
				} elseif ($changefreq < 2592000) {
					$changefreq = "monthly";
				} else {
					$changefreq = "yearly";
				}
				$url = "/";
				if ($p["folder"]) $url .= $p["folder"] . "/";
				$return .= '	<url>
		<loc>' . $_josh["site"]["full_url"] . $url . '</loc>
		<lastmod>' . josh_format_date_iso8601($p["approved_on"]) . '</lastmod>
		<changefreq>daily</changefreq>
		<priority>' . round($priority/10, 1) . '</priority>
	</url>
';
			}
			$return .= '</urlset>';
			return utf8_encode($return);
		}
	}
	return false;
}
?>