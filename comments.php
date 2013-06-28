<?php
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area">
	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<?php if (!empty($comments_by_type['comment'])) { ?>
            <h2 id="comments-title">
                <?php comment_count(); ?>
            </h2>

            <ol class="commentlist">
                <?php wp_list_comments( array( 'callback' => 'fanoe_comment', 'style' => 'ol', 'type'=>'comment' ) ); ?>
            </ol><!-- .commentlist -->
		<?php } if (!empty($comments_by_type['pings'])) { ?>
	 
            <h2 id="trackbacks-title"><?php trackback_count(); ?></h2>
	 
            <ol class="commentlist">
                <?php wp_list_comments( array( 'callback' => 'fanoe_comment', 'type' => 'pings' ) );?>
            </ol>
        <?php } ?>
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
            <nav id="comment-nav-below" class="navigation" role="navigation">
                <h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'fanoe' ); ?></h1>
                <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'fanoe' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'fanoe' ) ); ?></div>
            </nav>
		<?php endif; // check for comment navigation ?>

		<?php
		/* If there are no comments and comments are closed, let's leave a note.
		 * But we only want the note on posts and pages that had comments in the first place.
		 */
		if ( ! comments_open() && get_comments_number() ) : ?>
			<p class="nocomments"><?php _e( 'Comments are closed.' , 'fanoe' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php comment_form(array('comment_notes_after' => '', 'label_submit' => __('Submit Comment', 'fanoe' ))); ?>

</div><!-- #comments .comments-area -->