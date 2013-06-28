<?php get_header();?>
<div id="main">
    <div id="content">

		<?php if ( have_posts() ) : ?>

            <header class="page-header">
                <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'fanoe' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
            </header>

            <?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

                <?php
                    /* Include the Post-Format-specific template for the content.
                     * If you want to overload this in a child theme then include a file
                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                     */
                    get_template_part( 'content', get_post_format() );
                ?>

            <?php endwhile; ?>

		<?php else : ?>

            <article id="post-0" class="post no-results not-found">
                <header class="entry-header">
                    <h1 class="entry-title"><?php _e( 'Nothing Found', 'fanoe' ); ?></h1>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'fanoe' ); ?></p>
                    <?php get_search_form(); ?>
                </div><!-- .entry-content -->
            </article><!-- #post-0 -->

        <?php endif; ?>

	</div><!-- #content -->
	
	<?php if (  $wp_query->max_num_pages > 1 ) : ?>
		<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }else{ ?>
			
            <nav id="nav-below">
				<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'fanoe' ) ); ?></div>
				<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'fanoe' ) ); ?></div>
			</nav><!-- end nav-below -->
		<?php }?>
	<?php endif; ?>		
</div>

<?php get_sidebar(); ?>
<?php get_footer();?>