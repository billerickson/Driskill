<?php
/* Template Name: Landing */

add_filter( 'genesis_pre_get_option_site_layout', 'driskill_landing_page_layout' );
/**
 * Filter the layout option to force full width.
 *
 */
function driskill_landing_page_layout( $opt ) {
	return 'full-width-content';
}

/** Remove navigation, breadcrumbs, footer */
remove_action('genesis_before_header', 'genesis_do_nav');
remove_action('genesis_after_header', 'genesis_do_subnav');
remove_action('genesis_before_loop', 'genesis_do_breadcrumbs');
remove_action('genesis_footer', 'genesis_footer_markup_open', 5);
remove_action('genesis_footer', 'genesis_do_footer');
remove_action('genesis_footer', 'genesis_footer_markup_close', 15);

/**
 * Replace default header to remove widget area
 */
remove_action( 'genesis_header', 'genesis_do_header' );
add_action( 'genesis_header', 'driskill_landing_header' ); 
function driskill_landing_header() {

	echo '<div id="title-area">';
	do_action( 'genesis_site_title' );
	do_action( 'genesis_site_description' );
	echo '</div><!-- end #title-area -->';

}
 
genesis();
?>