<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the wordpress construct of pages
 * and that other 'pages' on your wordpress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage MissionIQ
 * @since MissionIQ 1.0
 */

get_header();

if ( have_posts() ) while ( have_posts() ) : the_post(); 

if (is_front_page()) {
	//echo '<h2>' . the_title() . '</h2>';
	the_content();
} else { 
	//draw sidebar and page
	?>
<div class="row">
	<div class="span12 banner"></div>
</div>
<div class="row">
	<div class="span3 sidebar">

<?php
/* old full nav removed per meredith 3/7
if (!isset($navigation)) $navigation = missioniq_nav();

echo '<div class="well sidebar-nav"><ul class="nav nav-list">';
			
foreach ($navigation as $key=>$p) {
	$active = ($p['active']) ? ' class="active"' : '';
	echo '<li' . $active . '><a href="' . $p['url'] . '">' . $p['title'] . '</a>';
	if (count($p['children'])) {
		echo '<ul class="nav nav-list">';
		foreach ($p['children'] as $child) {
			$active = ($child['active']) ? ' class="active"' : '';
			echo '<li' . $active . '><a href="' . $child['url'] . '">' . $child['title'] . '</a></li>';
		}
		echo '</ul>';
	}
	echo '</li>';
}
echo '</ul></div>';
*/

//draw sidebar
$query		= new WP_Query();
$children	= $query->query(array('post_type'=>'page', 'post_parent'=>get_the_ID(), 'orderby'=>'menu_order'));
if (count($children)) {
	//is parent of section
	echo '<h3 class="current_page_item"><a href="' . get_permalink() . '"><i class="icon-arrow-right"></i> ' . get_the_title() . '</a></h3><ul class="sidenav">';
	foreach ($children as $child) echo '<li><a href="' . get_permalink($child->ID) . '"><i class="icon-arrow-right"></i> ' . $child->post_title . '</a></li>';
	echo '</ul>';
} elseif ($post->post_parent) {
	$parent = get_page($post->post_parent);
	echo '<h3><a href="' . get_permalink($post->post_parent) . '"><i class="icon-arrow-right"></i> ' . $parent->post_title . '</a></h3><ul class="sidenav">';
	wp_list_pages(array('child_of'=>$post->post_parent, 'sort_column'=>'menu_order', 'title_li'=>false, 'link_before'=>'<i class="icon-arrow-right"></i> '));
	echo '</ul>';
} else {
	echo '&nbsp;';
}

//display custom sidebar field if present
$custom = get_post_custom();
if (!empty($custom['Sidebar'][0])) echo '<div class="custom">' . $custom['Sidebar'][0] . '</div>';


?>

	</div>
	
	<div class="span9">

		<h1 class="title"><?php the_title(); ?></h1>
		
		<!--<ul class="breadcrumb">
			<li><a href="/">Home</a> <span class="divider">/</span></li>
			<?php
			/*
if ($post->post_parent) {
		        $page = get_page($post->post_parent);
		        echo '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . ' <span class="divider">/</span></a>';
				//<li><a href="/about-us/">About Us</a> <span class="divider">/</span></li>
			}
			echo '<li class="active"><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
*/
			?>
		</ul>-->
		
		<div class="content"><?php the_content(); ?></div>
	</div>
</div>
<?php
	
} 



wp_link_pages( array( 'before' => '' . __( 'Pages:', 'twentyten' ), 'after' => '' ) ); 

//edit_post_link( __( 'Edit', 'twentyten' ), '', '' ); 

//comments_template( '', true ); 

endwhile;

//get_sidebar();

get_footer();