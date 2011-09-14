<?php
/** Start the engine */
require_once( TEMPLATEPATH . '/lib/init.php' );


// ** Child Theme (do not remove) ** //
define( 'CHILD_THEME_NAME', 'Driskill Theme' );
define( 'CHILD_THEME_URL', 'http://market.studiopress.com/themes/driskill' );
define( 'CHILD_THEME_VERSION', '1.0' );
define( 'CHILD_THEME_SLUG', 'driskill' );

// ** Translations ** //
load_child_theme_textdomain( 'driskill', get_stylesheet_directory() . '/lib/languages');  
	
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

// Add suport for custom background 
add_custom_background();

// Add support for custom header 
add_theme_support( 'genesis-custom-header', array( 'width' => 270, 'height' => 120, 'textcolor' => '333', 'admin_header_callback' => 'driskill_admin_style', 'header_callback' => 'driskill_custom_header_style' ) );

function driskill_admin_style() {

	$googlefont = '@import url(http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300);';
	$headimg = sprintf( '.appearance_page_custom-header #headimg { background: url(%s) no-repeat;  min-height: %spx; }', get_header_image(), HEADER_IMAGE_HEIGHT );
	$h1 = sprintf( '#headimg h1, #headimg h1 a { color: #%s; font-family: Open Sans Condensed, arial, serif; font-size: 36px; font-weight: normal; line-height: 40px; margin: 0; text-transform: uppercase; text-decoration: none; }', esc_html( get_header_textcolor() ) );
	$desc = sprintf( '#headimg #desc { color: #%s; font-family: Arial, Helvetia, sans-serif; font-size: 12px; font-style:italic; }', esc_html( get_header_textcolor() ) );

	printf( '<style type="text/css">%1$s %2$s %3$s %4$s</style>', $googlefont, $headimg, $h1, $desc );

}

function driskill_custom_header_style() {

	/** If there is a custom image, output css */
	$image = esc_url( get_header_image() );
	
	/** If no image is set, for some reason WP returns header.png, so this makes sure an actual image was uploaded */
	$default = get_stylesheet_directory_uri() . '/images/header.png';
	if ( !empty( $image ) && $default !== $image )
		printf( '<style type="text/css">#header #title-area #title { background: url(%s) no-repeat; width: 270px; height: 120px; }</style>', $image );
		
	/** If there is a custom text color, output css */
	$text = esc_html( get_header_textcolor() );
	if( !empty( $text ) )
		printf( '<style type="text/css">#title a, #title a:hover, #description { color: #%s; }</style>', $text );

}

// Setup Footer Widgets
add_theme_support( 'genesis-footer-widgets', 3 );

// Setup Image Sizes
add_image_size( 'driskill_featured', '915', '260', true);

// Setup Styles
add_action( 'init', 'driskill_setup_styles' );
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
	$defaults['slideshow_width'] = '915';
	return $defaults;
}


// ** Frontend Settings ** //	

// Viewport Meta Tag for Mobile Browsers
add_action( 'genesis_meta', 'driskill_viewport_meta_tag' );
function driskill_viewport_meta_tag() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

// Body Classes
add_filter( 'body_class', 'driskill_body_classes' );
function driskill_body_classes( $classes ) {
	if ( is_active_sidebar( 'header-right' ) ) $classes[] = 'header-widget';
	return $classes;
}

// Featured Image
add_action('genesis_before_content_sidebar_wrap', 'driskill_featured_image');
function driskill_featured_image() {
	global $post;
	if ( has_post_thumbnail() && is_singular() ) {
		$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'driskill_featured' );
		// For some reason has_post_thumbnail() sometimes returns true even if there's no thumbnail. This prevents a blank image from showing up.
		if ( !empty( $image_url[0] ) )
			echo '<p class="featured-image"><img src="' . $image_url[0] . '" alt="' . the_title_attribute( 'echo=0' ) . ' Image" /></p>';
	}
}

// Move Sidebar out of content-sidebar-wrap, this is necessary for 3 column responsive design.
remove_action('genesis_after_content', 'genesis_get_sidebar');
add_action('genesis_after_content_sidebar_wrap', 'genesis_get_sidebar', 9);

