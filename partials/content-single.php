<?php
/**
 * Template part for displaying content of posts in single view.
 *
 * @version 2.0.0
 *
 * @package Fanoe
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php
		/**
		 * Display entry header meta.
		 */
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
		the_content();

		/**
		 * Display post pagination.
		 */
		wp_link_pages(); ?>
	</div>
	<footer class="entry-footer">
		<?php fanoe_the_footer_meta(); ?>
	</footer>
</article>
