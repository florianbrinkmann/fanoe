<?php
/**
 * Template tags, used in template files.
 *
 * @version 2.0.0
 *
 * @package Fanoe
 */

if ( ! function_exists( 'fanoe_get_custom_logo' ) ) {
	/**
	 * Get the custom logo.
	 *
	 * @return string Custom logo markup or empty string.
	 */
	function fanoe_get_custom_logo() {
		/**
		 * Wrap inside function_exists() to preserve back compat with WordPress versions older than 4.5.
		 */
		if ( function_exists( 'get_custom_logo' ) ) {
			/**
			 * Check if we have a custom logo.
			 */
			if ( has_custom_logo() ) {
				/**
				 * Return the custom logo.
				 */
				return get_custom_logo();
			}
		}

		/**
		 * Return empty string, if we do not have a custom logo or WordPress is older than 4.5.
		 */
		return '';
	}
} // End if().

if ( ! function_exists( 'fanoe_the_title' ) ) {
	/**
	 * Displays the title of a post wrapped with a heading and optionally with a link to the post.
	 *
	 * @param string $heading Type of heading.
	 * @param bool   $link    If the title should be linked to the single view or not.
	 *
	 * @return string Title markup.
	 */
	function fanoe_the_title( $heading, $link = true ) {
		/**
		 * Check if the title should be a link.
		 */
		if ( $link ) {
			/**
			 * Build the title markup.
			 */
			$title_markup = the_title(
				sprintf(
					'<%1$s class="entry-title"><a href="%2$s" rel="bookmark">',
					$heading, esc_url( get_permalink() )
				),
				sprintf( '</a></%s>', $heading ),
				false );
		} else {
			/**
			 * Build the title markup without a link.
			 */
			$title_markup = the_title(
				sprintf(
					'<%1$s class="entry-title">',
					$heading, esc_url( get_permalink() )
				),
				sprintf( '</%s>', $heading ),
				false );
		}

		echo $title_markup;
	}
} // End if().

if ( ! function_exists( 'fanoe_get_the_date' ) ) {
	/**
	 * Returns get_the_date() with or without a link to the single view.
	 *
	 * @param bool $link If the date should link to the single view.
	 *
	 * @return string Date markup.
	 */
	function fanoe_get_the_date( $link = true ) {
		if ( $link ) {
			$date_markup = sprintf(
				'<a href="%s">%s</a>',
				get_the_permalink(),
				get_the_date()
			);
		} else {
			$date_markup = get_the_date();
		}

		return $date_markup;
	}
} // End if().

if ( ! function_exists( 'fanoe_the_entry_header_meta' ) ) {
	/**
	 * Displays meta data for entry header.
	 */
	function fanoe_the_entry_header_meta() {
		/**
		 * Get the date, linked to the post.
		 */
		$meta_markup = sprintf(
			'<span class="entry-date">%s</span>',
			fanoe_get_the_date()
		);

		/**
		 * Get reactions separated by type.
		 */
		$comments_by_type = fanoe_get_comments_by_type();

		/**
		 * Get the comment count text.
		 */
		$comment_count_text = fanoe_get_comments_number_text( $comments_by_type );

		/**
		 * Check if we do not have an empty string from the funtion call.
		 */
		if ( '' !== $comment_count_text ) {
			$meta_markup .= sprintf(
				' <span class="comment-count">%s</span>',
				$comment_count_text
			);
		} // End if().

		/**
		 * Get the pings count text.
		 */
		$ping_count_text = fanoe_get_pings_number_text( $comments_by_type );

		/**
		 * Check if it is not empty.
		 */
		if ( '' !== $ping_count_text ) {
			$meta_markup .= sprintf(
				' <span class="ping-count">%s</span>',
				$ping_count_text
			);
		} // End if().

		/**
		 * Display the string.
		 */
		printf(
			'<p class="entry-meta">%s</p>',
			$meta_markup
		);
	}
} // End if().

if ( ! function_exists( 'fanoe_get_comments_by_type' ) ) {
	/**
	 * Returns the post reactions by type (comments and pingbacks).
	 *
	 * @return array Post reactions separated by type.
	 */
	function fanoe_get_comments_by_type() {
		$comment_args     = [
			'order'   => 'ASC',
			'orderby' => 'comment_date_gmt',
			'status'  => 'approve',
			'post_id' => get_the_ID(),
		];
		$comments         = get_comments( $comment_args );
		$comments_by_type = separate_comments( $comments );

		return $comments_by_type;
	}
}

if ( ! function_exists( 'fanoe_the_post_thumbnail' ) ) {
	/**
	 * Displays the post thumbnail with caption.
	 */
	function fanoe_the_post_thumbnail() {
		/**
		 * Check if we have a post thumbnail.
		 */
		if ( has_post_thumbnail() ) {
			printf(
				'<figure class="post-thumbnail"><a href="%s">%s</a>%s</figure>',
				get_permalink(),
				get_the_post_thumbnail( null, 'large' ),
				fanoe_get_post_thumbnail_caption()
			);
		} // End if().
	}
} // End if().

if ( ! function_exists( 'fanoe_the_content' ) ) {
	/**
	 * Displays the_content() with a more accessible more tag.
	 */
	function fanoe_the_content() {
		/* translators: visible text for the more tag */
		the_content(
			sprintf(
				'<span aria-hidden="true">%1s</span><span class="screen-reader-text">%2s</span>',
				__( 'Continue reading', 'fanoe' ),
				sprintf( /* translators: continue reading text for screen reader users. s=post title */
					__( 'Continue reading %s', 'fanoe' ),
					the_title( '', '', false )
				)
			)
		);
	}
} // End if().

if ( ! function_exists( 'fanoe_the_footer_meta' ) ) {
	/**
	 * Displays entry footer meta string.
	 */
	function fanoe_the_footer_meta() {
		/**
		 * Get categories list.
		 */
		$meta_string = sprintf( /* translators: 1=categories list; 2=author */
			__( 'Posted in %1$s by %2$s', 'fanoe' ),
			get_the_category_list( ', ' ),
			get_the_author()
		);

		/**
		 * Get the tags list.
		 */
		$tag_list = fanoe_get_tag_list();

		/**
		 * Check if we have tags.
		 */
		if ( '' !== $tag_list ) {
			/**
			 * Add tag list to meta string.
			 */
			$meta_string .= " · $tag_list";
		} // End if().

		/**
		 * Get the edit post link.
		 */
		$edit_post_link = get_edit_post_link();

		/**
		 * Check if we have an edit link.
		 */
		if ( null !== $edit_post_link ) {
			/**
			 * Add the link to the meta string.
			 */
			$meta_string .= sprintf(
				' · %s',
				sprintf(
					'<a href="%s">%s</a>',
					$edit_post_link,
					__( 'Edit', 'fanoe' ) )
			);
		} // End if().

		echo "<p>$meta_string</p>";
	}
} // End if().

if ( ! function_exists( 'fanoe_comment' ) ) {
	/**
	 * Displays comments.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 */
	function fanoe_comment( $comment, $args, $depth ) { ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="vcard">
				<?php
				/**
				 * Display the avatar.
				 */
				echo get_avatar( $comment, 44 );

				/**
				 * Display the author’s name and the date.
				 */
				printf( '<p class="comment-meta"><cite class="fn">%s</cite> · <a href="%s"><time datetime="%s">%s</time></a></p>',
					get_comment_author_link(),
					esc_url( get_comment_link( $comment->comment_ID ) ),
					get_comment_time( 'c' ),
					sprintf( /* translators: 1: date, 2: time */
						__( '%1$s @ %2$s', 'fanoe' ),
						get_comment_date(),
						get_comment_time()
					)
				); ?>
			</div>

			<?php
			/**
			 * Check if the comment is not approved yet.
			 */
			if ( '0' === $comment->comment_approved ) { ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'fanoe' ); ?></p>
			<?php } ?>

			<div class="comment-content">
				<?php
				/**
				 * Display the comment text.
				 */
				comment_text();

				/**
				 * Display the edit link.
				 */
				edit_comment_link( __( 'Edit', 'fanoe' ), '<p class="edit-link">', '</p>' ); ?>
			</div><!-- .comment-content -->

			<p class="reply">
				<?php comment_reply_link(
					array_merge( $args, [
						'reply_text' => __( 'Reply', 'fanoe' ),
						'depth'      => $depth,
						'max_depth'  => $args['max_depth'],
					] )
				); ?>
			</p>
		</div>
		<?php
	}
} // End if().

if ( ! function_exists( 'fanoe_the_posts_navigation' ) ) {
	function fanoe_the_posts_navigation() {
		the_posts_navigation( [
			'prev_text' => __( 'Older posts »', 'fanoe' ),
			'next_text' => __( '« Newer posts', 'fanoe' ),
		] );
	}
}
