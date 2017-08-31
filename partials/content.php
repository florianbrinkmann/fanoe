<?php
/**
 * Default template part for displaying post content.
 *
 * @version 2.0.0
 *
 * @package Fanoe
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php fanoe_the_title( 'h2' );
		fanoe_the_entry_header_meta(); ?>
	</header>
	<div class="entry-content">
		<?php
		/**
		 * Display the post thumbnail.
		 */
		fanoe_the_post_thumbnail();

		/**
		 * Display the content.
		 */
		fanoe_the_content();

		/**
		 * Display post pagination.
		 */
		wp_link_pages(); ?>
	</div>
	<footer class="entry-footer">
		<?php fanoe_the_footer_meta(); ?>
	</footer>
</article>
