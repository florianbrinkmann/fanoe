<?php get_header(); ?>
<div id="main">
	<div id="content">
		<article class="page">
			<header class="page-header">
				<h1><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'fanoe' ); ?></h1>
			</header>
            
            <div class="page-content">
                <p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'fanoe' ); ?></p>
                <?php get_search_form(); ?>
            </div>
		</article>
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

<?php get_sidebar();?>
<?php get_footer(); ?>