<?php
extract(joshlib());

function drawFirst() {
	return draw_doctype() . draw_container('head', 
		'<meta http-equiv="X-UA-Compatible" content="IE=Edge">' . 
		draw_meta_utf8() .
		draw_title() . 
		lib_get('wysihtml5,bootstrap') . 
		draw_css_src() . 
		draw_javascript_src('/js/global.js')
	) . draw_body_open() . '<div class="container">';
}

function drawForm($id) {
	return '<form>
		<div id="toolbar" class="toolbar" style="display: none;">
			<a class="btn" data-wysihtml5-command="bold" title="CTRL+B">bold</a>
			<a class="btn" data-wysihtml5-command="italic" title="CTRL+I">italic</a>
			<a class="btn" data-wysihtml5-command="createLink">link</a>
			<a class="btn" data-wysihtml5-command="insertImage">image</a>
			<a class="btn" data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h1">h1</a>
			<a class="btn" data-wysihtml5-command="formatBlock" data-wysihtml5-command-value="h2">h2</a>
			<a class="btn" data-wysihtml5-command="insertUnorderedList">ul</a>
			<a class="btn" data-wysihtml5-command="insertOrderedList">ol</a>
			<a class="btn" data-wysihtml5-action="change_view">html</a>
			
			<div data-wysihtml5-dialog="createLink" style="display: none;">
				<label>
					Link:
					<input data-wysihtml5-dialog-field="href" value="http://">
				</label>
				<a data-wysihtml5-dialog-action="save">OK</a>&nbsp;<a data-wysihtml5-dialog-action="cancel">Cancel</a>
			</div>
			
			<div data-wysihtml5-dialog="insertImage" style="display: none;">
				<label>
					Image:
					<input data-wysihtml5-dialog-field="src" value="http://">
				</label>
				<label>
					Align:
					<select data-wysihtml5-dialog-field="className">
						<option value="">default</option>
						<option value="wysiwyg-float-left">left</option>
						<option value="wysiwyg-float-right">right</option>
					</select>
				</label>
				<a data-wysihtml5-dialog-action="save">OK</a>&nbsp;<a data-wysihtml5-dialog-action="cancel">Cancel</a>
			</div>
		</div>
		<textarea id="textarea" class="span7" placeholder="Enter text&hellip;"></textarea>
		<input class="btn" type="button" value=" Save Changes ">
	</form>';
}

function drawLast() {
	return '</div></body></html>';	
}

function joshlib() {
	//look for joshlib at joshlib/index.php, ../joshlib/index.php, all the way down
	global $_josh;
	$count = substr_count($_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'], '/');
	for ($i = 0; $i < $count; $i++) if (@include(str_repeat('../', $i) . 'joshlib/index.php')) return $_josh;
	die('Could not find Joshlib.');
}