<?php
/**
 * Template for displaying page content.
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
			 * Check for posts.
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
					 * Include partials/content-page.php to display page’s content.
					 */
					get_template_part( 'partials/content', 'page' );
				} // End while().
			} // End if(). ?>
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
