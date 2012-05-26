<?php
global $navigation;
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage MissionIQ
 * @since MissionIQ 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 * We filter the output of wp_title() a bit -- see
	 * twentyten_filter_wp_title() in functions.php.
	 */
	wp_title( '|', true, 'right' );

	?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?php bloginfo( 'description' ); ?>">
<!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script> <![endif]--><!--//-->
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_directory' ); ?>/bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<script src="<?php bloginfo( 'template_directory' ); ?>/js/jquery-1.7.1.min.js"></script>
		<script src="<?php bloginfo( 'template_directory' ); ?>/bootstrap/js/bootstrap.min.js"></script>
		<script>
		$('.dropdown-toggle').dropdown();
		</script>
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).

	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	 Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

<body <?php body_class(); ?>>

		<div class="navbar">
			<div class="navbar-inner">
				<div class="container">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<a class="brand" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					<div class="nav-collapse" role="navigation">

						 <?php 
						 //load custom nav menu so wordpress will play with twitter bootstrap
						 
						 //render loaded $pages array
						 echo '<ul class="nav">';
						if (!isset($navigation)) $navigation = missioniq_nav();

						 foreach ($navigation as $key=>$p) {
					 		$active = ($p['active']) ? ' class="active"' : '';
						 	if (count($p['children'])) {
						 		//is a dropdown
								echo '<li class="dropdown"' . $active . '>
									<a href="' . $p['url'] . '">' . $p['title'] . ' <b class="caret"></b></a>
									<ul class="dropdown-menu">
										<!--<li' . $active . '><a href="' . $p['url'] . '">Overview</a></li>-->
									';
								foreach ($p['children'] as $child) {
					 				$active = ($child['active']) ? ' class="active"' : '';
							 		echo '<li' . $active . '><a href="' . $child['url'] . '">' . $child['title'] . '</a></li>';
								}
								echo '</ul></li>';
						 	} else {
						 		//not a dropdown
						 		echo '<li' . $active . '><a href="' . $p['url'] . '">' . $p['title'] . '</a></li>';
						 	}
						 }
						 echo '</ul>';
						 ?>  
					</div>
				</div>
			</div>
		</div>
		
		<div class="container">