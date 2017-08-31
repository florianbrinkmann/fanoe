<?php
/**
 * Customize related funtions.
 *
 * @version 2.0.0
 *
 * @package Fanoe
 */

/**
 * Customizer settings
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function fanoe_customize_register( $wp_customize ) {
	/**
	 * Add design color setting.
	 */
	$wp_customize->add_setting( 'design_color', [
			'default'           => '#27ae60',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_hex_color',
		]
	);

	/**
	 * Add design color control.
	 */
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'design_color',
			[
				'label'   => __( 'Main Color of the Design', 'fanoe' ),
				'section' => 'theme_options',
			]
		)
	);

	$wp_customize->add_section( 'content', [
		'title' => __( 'Theme options', 'fanoe' ),
	] );
}

/**
 * Customizer CSS – changes the design color.
 */
function fanoe_insert_customize_css() {
	/**
	 * Get design color.
	 */
	$design_color = get_theme_mod( 'design_color', '#27ae60' );

	/**
	 * Check if it is not the default value.
	 */
	if ( '#27ae60' !== $design_color ) {
		?>
		<style>
			a, .format-status header h1 a:hover, .format-status header h1 a:active, .format-status header h1 a:focus, .site-title a:hover, .site-title a:active, .site-title a:focus {
				color: <?php echo $design_color ; ?>;
			}

			a:focus, a:active, a:hover, .format-status, input[type=reset]:hover, input[type=submit]:hover, input[type=reset]:active, input[type=submit]:active, input[type=reset]:focus, input[type=submit]:focus {
				background: <?php echo $design_color ; ?>;
			}

			input[type=text]:hover, input[type=password]:hover, input[type=email]:hover, input[type=url]:hover, input[type=number]:hover, textarea:hover, input[type=text]:focus, input[type=password]:focus, input[type=email]:focus, input[type=url]:focus, input[type=number]:focus, textarea:focus {
				border-color: <?php echo $design_color ; ?>
			}
		</style>
	<?php } // End if().
}

