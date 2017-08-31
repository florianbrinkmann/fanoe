<?php
/**
 * Template for displaying the header
 *
 * @version 2.0.0
 *
 * @package Fanoe
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<?php
	/**
	 * Check if we are in a single view and the pings are open.
	 */
	if ( is_singular() && pings_open() ) { ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php }

	/**
	 * Fire wp_head action, which includes styles, scripts, et cetera, from core, themes, and plugins.
	 */
	wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="header-wrapper">
	<header class="branding" role="banner">
		<?php
		/**
		 * Include file which displays site title and discription or logo.
		 */
		get_template_part( 'partials/header/branding' ); ?>
	</header>
</div>
<div class="wrapper">
