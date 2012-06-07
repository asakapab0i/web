<?php
include('include.php');
$_josh['mode'] = 'dev';

$folder = DIRECTORY_ROOT . DIRECTORY_WRITE . '/lib/tinymce/jscripts/tiny_mce/plugins/filemanager/';

function fixTinymcePermissions($folder) {
	$files = file_folder($folder);
	
	foreach ($files as $f) {
		$name = str_replace($folder, '', $name);
		if ($f['type'] == 'dir') {

		} else {
			echo 'changing permissions for ' . $name . BR;
			chmod($f['name'], 0644);
		}
	}
	
}
