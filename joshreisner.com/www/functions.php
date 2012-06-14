<?php

function drawPost() {
?>	
<div class="post" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	<?php the_content('Read More &raquo;'); ?>
	<div class="meta">
		Posted on <?php the_time('F j, Y') ?> <?php edit_post_link('Edit', '| '); ?>
		<div class="btn-group tags">
			<a class="btn dropdown-toggle btn-mini" data-toggle="dropdown" href="#">
				Tags
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a href="#">Work</a></li>
				<li class="divider"></li>
				<li><a href="#">Work</a></li>
				<li><a href="#">Work</a></li>
			</ul>
		</div>
	</div>
</div>
<?php
}
			
if (function_exists('add_theme_support')) { 
	add_theme_support('post-thumbnails'); 
}

//remove gallery CSS
function remove_gallery_css($output) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $output);
}
add_filter('gallery_style', 'remove_gallery_css');

//remove gallery BRs
function remove_br_gallery($output) {
    return preg_replace('/<br style=(.*)>/mi', '', $output);
}
add_filter('the_content', 'remove_br_gallery', 11, 2);


//remove caption css via http://wp-snippets.com/remove-default-inline-style-of-wp-caption/
add_shortcode('wp_caption', 'fixed_img_caption_shortcode');
add_shortcode('caption', 'fixed_img_caption_shortcode');

function fixed_img_caption_shortcode($attr, $content = null) {
	// Allow plugins/themes to override the default caption template.
	$output = apply_filters('img_caption_shortcode', '', $attr, $content);
	if ( $output != '' ) return $output;
	extract(shortcode_atts(array(
		'id'=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''), $attr));
	if ( 1 > (int) $width || empty($caption) )
	return $content;
	if ( $id ) $id = 'id="' . esc_attr($id) . '" ';
	return '<div ' . $id . 'class="wp-caption ' . esc_attr($align)
	. '">'
	. do_shortcode( $content ) . '<p class="wp-caption-text">'
	. $caption . '</p></div>';
}

//functions todo remove
$_josh['numbers']				= array('zero','one','two','three','four','five','six','seven','eight','nine');

function format_time_elapsed($timestamp) {
	if (!is_int($timestamp)) $timestamp = strtotime($timestamp);
	$elapsed = date("U") - $timestamp;
	
	if ($elapsed > 604800) {
		return format_quantitize(round($elapsed / 604800), 'week') . ' ago';
	} elseif ($elapsed > 86400) {
		return format_quantitize(round($elapsed / 86400), 'day') . ' ago';
	} elseif ($elapsed > 3600) {
		return format_quantitize(round($elapsed / 3600), 'hour') . ' ago';
	} elseif ($elapsed > 60) {
		return format_quantitize(round($elapsed / 60), 'minute') . ' ago';
	} elseif ($elapsed > 0) {
		return 'Just Now';	
	} else { 
		return 'Future';
	}
}

function format_quantity($quantity) {
	global $_josh;
	if ($quantity == 0) {
		$return = 'no';
	} elseif ($quantity < 10) {
		$return = $_josh['numbers'][$quantity];
	} else {
		$return = $quantity;
	}
	return $return;
}

function format_quantitize($quantity, $entity) {
	$quantity = format_quantity($quantity) . ' ';
	if ($quantity == 'one ') {
		$return = $quantity . format_singular($entity);
	} else {
		$return = $quantity . format_pluralize($entity);
	}
	return $return;
}

function format_singular($string) {
	if (format_text_ends('ies', $string)) {
		return substr($string, 0, $string-3) . 'y';
	} elseif (format_text_ends('s', $string)) {
		return substr($string, 0, $string-1);
	}
	return $string;
}

function format_text_ends($needle, $haystack) {
	$needle_length = strlen($needle);
	if (strToLower(substr($haystack, (0 - $needle_length))) == strToLower($needle)) return substr($haystack, 0, strlen($haystack) - $needle_length);
	return false;
}

function format_pluralize($entity, $count=2) {
	if ($count == 1) return $entity;
	
	$length = strlen($entity);
	if (substr($entity, -1) == 's') {
		//already ends in an s
		return $entity;
	} elseif (substr(strtolower($entity), -6) == ' media') {
		//needs no change
		return $entity;
	} elseif (in_array($entity, array('day'))) {
		//nonstandard behavior
		return $entity . 's';	
	} elseif (substr($entity, -1) == 'y') {
		//ends in an ies
		return substr($entity, 0, ($length - 1)) . 'ies';
	} else {
		//needs just an s
		return $entity . 's';
	}
}


if (!isset($content_width)) $content_width = 830;

if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
}

add_editor_style();