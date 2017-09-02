<?php
/**
 * Template for displaying the sidebar.
 *
 * @version 2.0.0
 *
 * @package Fanoe
 */

?>
<button class="sidebar-button -open">
	<span class="screen-reader-text"><?php _e( 'Show Sidebar', 'fanoe' ); ?></span>
	<span aria-hidden="true">≡</span>
</button>
<aside class="sidebar" role="sidebar">
	<button class="sidebar-button -close">
		<span class="screen-reader-text"><?php _e( 'Close Sidebar', 'fanoe' ); ?></span>
		<span aria-hidden="true">≡</span>
	</button>
	<div class="sidebar-content">
		<?php
		/**
		 * Check if we have widgets in the sidebar and display them.
		 */
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			dynamic_sidebar( 'sidebar-1' );
		} ?>
		<p class="theme-author">
			<?php printf(
				__( 'Theme: Fanoe by %s', 'fanoe' ),
				sprintf(
					'<a rel="nofollow" href="%s">Florian Brinkmann</a>',
					__( 'https://florianbrinkmann.com/en/', 'fanoe' )
				)
			); ?>
		</p>
	</div>
</aside>
