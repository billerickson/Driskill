<?php
/** Start the engine */
require_once( TEMPLATEPATH . '/lib/init.php' );


// ** Child Theme (do not remove) ** //
define( 'CHILD_THEME_NAME', 'Driskill Theme' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/themes/driskill' );
define( 'CHILD_THEME_VERSION', '1.0' );
define( 'CHILD_THEME_SLUG', 'driskill' );
	
// ** Backend Settings ** //
// Setup Sidebars
genesis_register_sidebar( array( 
	'name' => __( 'Home Header', 'driskill' ), 
	'id' => 'home-header' 
) );

genesis_register_sidebar( array( 
	'name' => __( 'Home Content', 'driskill' ), 
	'id' => 'home-content' 
) );

genesis_register_sidebar( array( 
	'name' => __( 'Home Sidebar', 'driskill' ), 
	'id' => 'home-sidebar' 
) );

genesis_register_sidebar( array( 
	'name' => __( 'Home Footer 1', 'driskill' ), 
	'id' => 'home-footer-1' 
) );

genesis_register_sidebar( array( 
	'name' => __( 'Home Footer 2', 'driskill' ), 
	'id' => 'home-footer-2' 
) );

// Setup Footer Widgets
add_theme_support( 'genesis-footer-widgets', 3 );

// Setup Image Sizes
add_image_size( 'driskill_featured', '900', '260', true);

// Setup Styles
add_action( 'init', 'driskill_setup_styles', 15 );
function driskill_setup_styles() {

	// If running Genesis 1.8 or later, use the Genesis Styles option
	if ( version_compare( PARENT_THEME_VERSION, '1.7.9', '>' ) ) {	
		add_theme_support( 'genesis-style-selector', array( 'driskill-dark' => 'Dark' ) );
	
	// If older than 1.8, build it ourselves
	} else {
		include_once( CHILD_DIR . '/lib/styles.php' );
	}
}

// Set Genesis Slider Defaults
add_filter( 'genesis_slider_settings_defaults', 'driskill_slider_defaults' );
function driskill_slider_defaults( $defaults ) {
	$defaults['slideshow_height'] = '260';
	$defaults['slideshow_width'] = '900';
	return $defaults;
}


// ** Frontend Settings ** //	
// Featured Image
add_action('genesis_before_content_sidebar_wrap', 'driskill_featured_image');
function driskill_featured_image() {
	global $post;
	if ( has_post_thumbnail() && is_singular() ) {
		$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'driskill_featured' );
		echo '<p class="featured-image"><img src="' . $image_url[0] . '" alt="' . the_title_attribute( 'echo=0' ) . ' Image" /></p>';
	}
}

// Move Sidebar out of content-sidebar-wrap
remove_action('genesis_after_content', 'genesis_get_sidebar');
add_action('genesis_after_content_sidebar_wrap', 'genesis_get_sidebar', 9);
