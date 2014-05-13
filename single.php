<?php get_header();?>
<div id="main">
	
    <div id="content">
		
		<?php while ( have_posts() ) : the_post(); ?>

			<?php
            /**
             * The template for displaying content in the single.php template
             *
             */
            ?>
                        
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    
					<?php if ( 'post' == get_post_type() ) : ?>
                    
                    <div class="entry-meta">
                        <?php the_time(__('F j, Y \@ g:i a', 'fanoe')); ?>
                    </div><!-- .entry-meta -->
                   
                    <?php endif; ?>
                
                </header><!-- .entry-header -->
                        
                <div class="entry-content">
					<?php if ( has_post_thumbnail() ) : ?>
                    <figure class="post-thumb-container">
                        <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'fanoe' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php the_post_thumbnail();?></a>
                        <?php echo fanoe_post_thumbnail_caption();?>
                    </figure>
                    <?php endif; ?>
                    <?php the_content(); ?>
                    <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'fanoe' ) . '</span>', 'after' => '</div>' ) ); ?>
					<?php $share_btns_singleview = get_theme_mod( 'share_btns_singleview' ); if($share_btns_singleview == 0){}else{ ?>
		
                        <div id="share" class="clearfix">
                            <ul class="social">
                                <li><a class="icon-gplus" href="https://plus.google.com/share?url=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;title=<?php echo rawurlencode(strip_tags(get_the_title())) ?>" target="blank" title="<?php _e('Share on Google +', 'fanoe')?>"></a></li>
                                <li><a class="icon-twitter" href="https://twitter.com/intent/tweet?source=webclient&amp;text=<?php echo rawurlencode(strip_tags(get_the_title())) ?>%20<?php echo urlencode(get_permalink($post->ID)); ?>" target="blank" title="<?php _e('Share on Twitter', 'fanoe')?>"></a></li>
                                <li><a class="icon-facebook" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;t=<?php echo rawurlencode(strip_tags(get_the_title())) ?>" target="blank" title="<?php _e('Share on Facebook', 'fanoe')?>"></a></li>
                                <li><a class="icon-linkedin" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;title=<?php echo rawurlencode(strip_tags(get_the_title())) ?>" target="blank" title="<?php _e('Share on LinkedIn', 'fanoe')?>"></a></li>
                            </ul>
                            <a onclick="javascript:print();" href="#" class="social"><i class="icon-print"></i></a>
                        </div>
                    <?php } ?>

                </div><!-- .entry-content -->
                        
                <footer class="entry-meta">
                    <?php
                        /* translators: used between list items, there is a space after the comma */
                        $categories_list = get_the_category_list( __( ', ', 'fanoe' ) );
            
                        /* translators: used between list items, there is a space after the comma */
                        $tag_list = get_the_tag_list( '', __( ', ', 'fanoe' ) );
                        if ( '' != $tag_list ) {
                            $utility_text = __( 'This entry was posted in %1$s and tagged %2$s by <a href="%6$s">%5$s</a>.<br>Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'fanoe' );
                        } elseif ( '' != $categories_list ) {
                            $utility_text = __( 'This entry was posted in %1$s by <a href="%6$s">%5$s</a>.<br>Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'fanoe' );
                        } else {
                            $utility_text = __( 'This entry was posted by <a href="%6$s">%5$s</a>.<br>Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'fanoe' );
                        }
            			
                        printf(
                            $utility_text,
                            $categories_list,
                            $tag_list,
                            esc_url( get_permalink() ),
                            the_title_attribute( 'echo=0' ),
                            get_the_author(),
                            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )
                        );
                    ?>
					<?php edit_post_link( __( 'Edit', 'fanoe' ), '<span class="edit-link">', '</span>' ); ?>
                        
                </footer><!-- .entry-meta -->
            
            </article><!-- #post-<?php the_ID(); ?> -->
        

		<?php $author_bio = get_theme_mod( 'author_bio' );if($author_bio ==0){?>
			
			<?php if ( get_the_author_meta( 'description' ) && ( ! function_exists( 'is_multi_author' ) || is_multi_author() ) ) : ?>
				
                <div id="author-info" class="clearfix">
					
                    <div id="author-avatar">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'fanoe_author_bio_avatar_size', 92 ) ); ?>
					</div><!-- #author-avatar -->
					
                    <div id="author-description">
						<h3><?php printf( __( 'About %s', 'fanoe' ), get_the_author() ); ?></h3>
						
						<p><?php the_author_meta( 'description' ); ?><br>
						
							<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
							<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'fanoe' ), get_the_author() ); ?>
							</a></p>
					
                    </div><!-- #author-description -->
				
                </div><!-- #author-info -->
			
			<?php endif; ?>
			
			<?php }else{if ( get_the_author_meta( 'description' )) :?>
				
                <div id="author-info" class="clearfix">
					
                    <div id="author-avatar">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'fanoe_author_bio_avatar_size', 92 ) ); ?>
					</div><!-- #author-avatar -->
					
                    <div id="author-description">
						<h3><?php printf( __( 'About %s', 'fanoe' ), get_the_author() ); ?></h3>
						
						<p><?php the_author_meta( 'description' ); ?><br>
						
							<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
							<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'fanoe' ), get_the_author() ); ?>
							</a></p>
					
                    </div><!-- #author-description -->
				
                </div><!-- #author-info -->
			
			<?php endif; }?>
            
            <nav id="nav-single" class="clearfix">
                <h3 class="assistive-text"><?php _e( 'Post navigation', 'fanoe' ); ?></h3>
                <span class="nav-previous"><?php previous_post_link(); ?></span>
                <span class="nav-next"><?php next_post_link(); ?></span>
            </nav><!-- #nav-single -->

            <?php comments_template( '', true ); ?>

		<?php endwhile; // end of the loop. ?>

	</div><!-- #content -->
	
	<?php if (  $wp_query->max_num_pages > 1 ) : ?>
        
		<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }else{ ?>
            
            <nav id="nav-below">
                <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'fanoe' ) ); ?></div>
                <div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'fanoe' ) ); ?></div>
            </nav><!-- end nav-below -->
        
		<?php } ?>	
	
	<?php endif;?>	

</div>

<?php get_sidebar(); ?>
<?php get_footer();?>