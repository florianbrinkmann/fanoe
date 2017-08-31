<?php
/**
 * Main template file. Fallback for everything in the template hierarchy.
 *
 * @version 2.0.0
 *
 * @package Fanoe
 */

/**
 * Include header.php.
 */
get_header(); ?>
	<main class="main">
		<div class="content">
			<?php
			/**
			 * Check if we have posts.
			 */
			if ( have_posts() ) {
				/**
				 * Loop them.
				 */
				while ( have_posts() ) {
					/**
					 * Setup post.
					 */
					the_post();

					/**
					 * Include template part for displaying the post’s content.
					 */
					get_template_part( 'partials/content', get_post_format() );
				} // End while().
			} else {
				/**
				 * We have no posts, so include partials/content-none.php.
				 */
				get_template_part( 'partials/content', 'none' );
			} // End if().

			/**
			 * Display the posts navigation.
			 */
			fanoe_the_posts_navigation(); ?>
		</div>
	</main>
<?php
/**
 * Include sidebar.php.
 */
get_sidebar();

/**
 * Include footer.php.
 */
get_footer();
