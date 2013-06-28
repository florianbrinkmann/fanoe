<?php get_header();?>

<div id="main">
	<div id="content">
		<?php if ( have_posts() ): while ( have_posts() ) : the_post();?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header><!-- .entry-header -->
            
                <div class="entry-content">
                    <?php the_content(); ?>
                </div><!-- .entry-content -->
                
                <footer class="entry-meta">
                    <?php edit_post_link( __( 'Edit', 'fanoe' ), '<span class="edit-link">', '</span>' ); ?>
                </footer><!-- .entry-meta -->
            </article><!-- #post-<?php the_ID(); ?> -->
		<?php endwhile; endif;?>
	</div>
    
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