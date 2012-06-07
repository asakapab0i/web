<?php
extract(joshlib());

//set up site architecture
$sections = array('company', 'work', 'press', 'contact');
$pages = array(
	'company'=>array('/company/story/'=>'Story', '/company/philosophy/'=>'Philosophy', '/company/earth/'=>'Earth'),
	'work'=>array()
);
$collections = db_table('SELECT id, title FROM user_collections WHERE is_active = 1 AND is_published = 1 ORDER BY precedence');
foreach ($collections as $c) $pages['work']['/work/?c=' . $c['id']] = $c['title'];

function drawTop() {
	global $request, $sections, $pages, $galleries;
		
	//navigation
	$options = array();	
	foreach ($sections as $s) $options['/' . $s . '/'] = $s;
	$main_nav = draw_nav($options, 'text', 'nav main', '/' . $request['folder'] . '/');
	
	//subnav
	if (isset($pages[$request['folder']])) {
		$sub_nav = draw_nav($pages[$request['folder']], 'text', 'nav sub', array('c'=>url_id('c')));
	} else {
		$sub_nav = '&nbsp;';
	}
	
	$return = url_header_utf8() . draw_doctype() . 
		draw_container('head',
			draw_meta_utf8() .
			draw_title('naula workshop | custom high-end furniture manufacturing and unique upholstery') .
			draw_javascript_src('http://fast.fonts.com/jsapi/3076311d-d861-4aa2-9fc1-3aa472a67bf0.js') . 
			draw_css_src('/css/global.css') .
			lib_get('modernizr') . 
			draw_meta_description('Naula workshop is a Brooklyn based manufacturer that specializes in custom high-end furniture designs and unique upholstery.') .
			draw_meta_keywords('Angel Naula, custom furniture, contemporary furniture, modern furniture, transitional furniture, interior designer, upholstery, craftsmanship, resdential and commercial, New York')
		) . draw_body_open() . '
			<table width="880" border="0" cellpadding="0" cellspacing="0">
				<tr><td class="frame_top" colspan="6"></td></tr>
				<tr>
					<td width="20" height="540" align="left" valign="top" class="frame_left">&nbsp;</td>
					<td colspan="4" valign="top" class="white">
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td width="210" rowspan="4" valign="top" class="logo">' . draw_img('/images/logo.png', '/') . '</td>
								<td width="630" height="65" valign="top">&nbsp;</td>
							</tr>
							<tr><td height="30" valign="top">' . $main_nav . '</td></tr>
							<tr><td height="30" valign="top">' . $sub_nav . '</td></tr>
							<tr><td height="25" valign="top">&nbsp;</td></tr>
							<tr>
								<td height="398" colspan="2" valign="top" id="main"><div id="inner">';
	return $return;
}

function drawBottom() {
	global $request;
	$return = '					</div></td>
							</tr>
						</table>' .
					'</td>
					<td width="20" valign="top" class="frame_right">&nbsp;</td>
				</tr>
				<tr>
					<td height="40" colspan="6" valign="top">' . draw_img('/images/frame/bottom.png') . '</td>
				</tr>
				<tr class="footer">
					<td height="60">&nbsp;</td>
					<td width="210" valign="top" class="bottom_copy">
						<span class="bottom_heading">naula</span><br>
						<span class="bottom_heading">T</span> 718.628.1912<br>
						<span class="bottom_heading">F </span>718.628.1916
					</td>
					<td width="210" valign="top" class="bottom_copy">
						<strong>Brooklyn Showroom</strong><br>
						349 Suydam Street, Third Floor<br>
						Brooklyn, NY 11237<br>
						212.470.6796<br>
						' . draw_link('mailto:showroom@naulaworkshop.com') . '
					</td>
					<td width="210" valign="top">&nbsp;</td>
					<td width="210" valign="top" class="bottom_copy">
						<ul class="social">
							<li><a href="http://www.facebook.com/NaulaWorkshop"><i class="icon-facebook-sign"></i></a></li>
							<li><a href="https://twitter.com/#!/NaulaShowroom"><i class="icon-twitter-sign"></i></a></li>
							<li><a href="http://www.linkedin.com/pub/angel-naula/18/3b4/635"><i class="icon-linkedin-sign"></i></a></li>
						</ul>
					</td>
					<td>&nbsp;</td>
				</tr>
			</table>' . cms_bar() . draw_google_analytics('UA-31847003-1') . 
		'
		</body>
	</html>';
	return $return;
}

function joshlib() {
	//look for joshlib at joshlib/index.php, ../joshlib/index.php, all the way down
	global $_josh;
	$count = substr_count($_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'], '/');
	for ($i = 0; $i < $count; $i++) if (@include(str_repeat('../', $i) . 'joshlib/index.php')) return $_josh;
	die('Could not find Joshlib.');
}