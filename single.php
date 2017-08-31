<?php
/**
 * Single view for posts.
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
			 * Check if we have a post.
			 */
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();

					/**
					 * Include partial for displaying single post content.
					 */
					get_template_part( 'partials/content', 'single' );

					/**
					 * Display links to next and previous posts.
					 */
					the_post_navigation();

					/**
					 * Include comments.php.
					 */
					comments_template();
				} // End while().
			} else {
				/**
				 * We do not have a post.
				 */
				get_template_part( 'partials/content', 'none' );
			} // End if().?>
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
