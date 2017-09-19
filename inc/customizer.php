<?php
/**
 * Customize related funtions.
 *
 * @version 2.0.1
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
				'label'   => __( 'Main color of the design', 'fanoe' ),
				'section' => 'theme_options',
			]
		)
	);

	$wp_customize->add_section( 'theme_options', [
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
			a, .js .sidebar .sidebar-button {
				color: <?php echo $design_color ; ?>;
			}

			a:focus {
				background: <?php echo $design_color ; ?>;
			}

			input:hover, input:focus, textarea:hover, textarea:focus {
				border-color: <?php echo $design_color ; ?>
			}
		</style>
	<?php } // End if().
}

