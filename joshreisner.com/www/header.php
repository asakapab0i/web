<?php
//page meta
$image = get_template_directory_uri() . '/images/icons/apple-touch-icon-precomposed-72x72.png';
if (is_single() && $thumbnail = get_post_thumbnail_id($post->ID)) {
	$image = wp_get_attachment_image_src($thumbnail);
	$image = $image[0];
}
$title = (is_single()) ? wp_title('', false) : get_bloginfo('name');
$title = trim($title);
$link = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">
		<title><?php echo $title; ?></title>
		<link rel="me" type="text/html" href="http://www.google.com/profiles/josh.reisner">
		<link rel="alternate" type="application/rss+xml" title="Josh Reisner (RSS 2.0)" href="http://feeds.feedburner.com/jrdc">
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		
		<!--search-->
		<meta name="description" content="<?php bloginfo('description'); ?>">
		<link rel="canonical" href="<?php echo $link;?>">
		
		<!--icons-->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri()?>/images/icons/favicon.png">	
		<link rel="apple-touch-icon-precomposed" href="<?php echo get_template_directory_uri()?>/images/icons/apple-touch-icon-precomposed-57x57.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo get_template_directory_uri()?>/images/icons/apple-touch-icon-precomposed-72x72.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo get_template_directory_uri()?>/images/icons/apple-touch-icon-precomposed-114x114.png">
		<link rel="apple-touch-startup-image" href="<?php echo get_template_directory_uri()?>/images/icons/startup-screen.png">

		<!--facebook-->
		<meta property="og:image" content="<?php echo $image;?>">
		<meta property="og:title" content="<?php echo $title;?>">
		<meta property="og:url" content="<?php echo $link;?>">
		<meta property="og:description" content="<?php bloginfo('description'); ?>">
		<meta property="og:site_name" content="<?php bloginfo('name');?>">
		<meta property="og:type" content="blog">
		
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri()?>/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri()?>/css/global.css">

		<?php 
		wp_enqueue_script('jquery');
		wp_head(); 
		?>
	</head>
	<body>
		<div class="container">
			<div class="row header">
				<div class="span12"><h1><a href="<?php echo home_url() ?>"><?php bloginfo('blog_name')?></a></h1></div>
			</div>
			<div class="row nav_categories">
				<div class="span9">
					<ul class="navigation">
						<li<?php if (!is_category()) echo ' class="selected"';?>><a href="/">Latest Posts</a></li>
					<?php 
					$categories = get_categories('orderby=term_group&order=desc&number=5');
					foreach ($categories as $c) {
						echo '<li';
						if (is_category() && in_category($c->term_id)) echo ' class="selected"';
						echo '><a href="' . get_category_link($c->term_id) . '">' . $c->name . '</a></li>';
					}
					?>
					</ul>
				</div>
				<div class="span3"></div>
			</div>