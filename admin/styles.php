<?php

add_action( 'genesis_theme_settings_metaboxes', 'driskill_add_style_settings_box', 10, 1 );
/**
 * Add new box to the Genesis->Theme Settings page.
 *
 */
function driskill_add_style_settings_box( $_genesis_theme_settings_pagehook ) {
	add_meta_box( 'genesis-theme-settings-style', __( 'Color style', 'driskill' ), 'driskill_theme_settings_style_box', $_genesis_theme_settings_pagehook, 'main', 'high' );
}

/**
 * Outputs the HTML necessary to display the extra form elements on Theme Settings
 *
 */
function driskill_theme_settings_style_box() {

	$color_schemes = apply_filters( 'driskill_colors', array(
		'driskill-light' 		=> __( 'Default', 'driskill' ),
		'driskill-dark'			=> __( 'Dark', 'driskill' ), 
	) );
	
?>

	<p><label><?php _e( 'Color Style', 'driskill' ); ?>:
		<select name="<?php echo GENESIS_SETTINGS_FIELD; ?>[style_selection]">
			<?php foreach ( $color_schemes as $id => $label ) {
				printf( '<option value="%s" %s>%s</option>', $id, selected( $id, genesis_get_option( 'style_selection' ), 0 ), $label );
			} ?>
		</select>
	</label></p>
	<p><span class="description"><?php _e( 'Please select the color style from the drop down list and save your settings.', 'driskill' ); ?></span></p>
	
<?php
}

add_filter( 'body_class', 'driskill_style_body_class' );

/**
 * Filters the body classes to add the proper style-specific class.
 *
 */
function driskill_style_body_class( $classes ) {

	if ( $style = genesis_get_option( 'style_selection' ) ) {
		$classes[] = esc_attr( sanitize_html_class( $style ) );
	}

	return $classes;

}

