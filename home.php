<?php
/**
 * Home
 *
 * @package		Driskill
 * @author		Bill Erickson <bill@billerickson.net>
 * @copyright	Copyright (c) 2011, Bill Erickson
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
 */
 
/**
 * Setup Home areas only if the widgets are populated
 *
 */
add_action('genesis_meta', 'driskill_home_setup');
function driskill_home_setup() {

	// Home Header
	if ( is_active_sidebar( 'home-header' ) ) 
		remove_action( 'genesis_before_content_sidebar_wrap', 'driskill_featured_image' );
		add_action( 'genesis_before_content_sidebar_wrap', 'driskill_home_header' );

	// Home Content
	if ( is_active_sidebar( 'home-content') ){
		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_loop', 'driskill_home_loop' );
	}
	
	// Home Sidebar
	if ( is_active_sidebar( 'home-sidebar' ) ) {
		remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
		add_action( 'genesis_sidebar', 'driskill_home_sidebar' );
	}
	
	// Home Footer
	if ( is_active_sidebar( 'home-footer-1') || is_active_sidebar( 'home-footer-2') ) 
		add_action( 'genesis_after_content_sidebar_wrap', 'driskill_home_footer' );

}

/**
 * Driskill Home Header
 *
 */
function driskill_home_header() {
	echo '<div class="home-header">';
	dynamic_sidebar( 'home-header' );
	echo '</div>';
}

/**
 * Replace post listing with Home Content widget area
 *
 */
function driskill_home_loop() {
	echo '<div class="home-content">';
	dynamic_sidebar( 'home-content' );
	echo '</div>';
}
 
/**
 * Replace Default Sidebar with Home Sidebar
 *
 */
function driskill_home_sidebar() {
	if ( !dynamic_sidebar('home-sidebar') ) {

		echo '<div class="widget widget_text"><div class="widget-wrap">';
			echo '<h4 class="widgettitle">';
				_e('Home Sidebar', 'genesis');
			echo '</h4>';
			echo '<div class="textwidget"><p>';
				printf(__('This is the Home Sidebar. You can add content to this area by visiting your <a href="%s">Widgets Panel</a> and adding new widgets to this area.', 'genesis'), admin_url('widgets.php'));
			echo '</p></div>';
		echo '</div></div>';

	}

}

/**
 * Add Home Footer
 *
 */
function driskill_home_footer() {
	echo '<div class="home-footer-wrapper"><div id="home-footer-1" class="one-half first">';
	dynamic_sidebar('home-footer-1'); 
	echo '</div><div id="home-footer-2" class="one-half">';	
	dynamic_sidebar('home-footer-2');
	echo '</div></div>';
}

genesis();
?>