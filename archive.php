<?php
/**
 * Template for displaying blog archives.
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
			if ( have_posts() ) { ?>
				<header class="page-header">
					<h1 class="page-title">
						<?php
						/**
						 * Display the archive title.
						 */
						the_archive_title(); ?>
					</h1>
				</header>
				<?php
				/**
				 * Loop the posts.
				 */
				while ( have_posts() ) {
					/**
					 * Setup the post.
					 */
					the_post();

					/**
					 * Include partial for displaying the content.
					 */
					get_template_part( 'partials/content', get_post_format() );
				}
			} else {
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
