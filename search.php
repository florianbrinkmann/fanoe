<?php
/**
 * Search template.
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
					<h1 class="page-title"><?php printf(
							__( 'Search results for: %s', 'fanoe' ),
							get_search_query()
						); ?></h1>
				</header>
				<?php
				/**
				 * Loop the posts-
				 */
				while ( have_posts() ) {
					/**
					 * Setup post.
					 */
					the_post();

					/**
					 * Include partial to display post content.
					 */
					get_template_part( 'partials/content', get_post_format() );

				} // End while().
			} else { ?>
				<article class="post no-results not-found">
					<header class="page-header">
						<h1 class="page-title"><?php printf(
								__( 'Nothing found for: %s', 'fanoe' ),
								get_search_query()
							); ?></h1>
					</header>
					<div class="entry-content">
						<?php
						/**
						 * Display the search form.
						 */
						get_search_form(); ?>
					</div><!-- .entry-content -->
				</article>
			<?php } // End if().

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
