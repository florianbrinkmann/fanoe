<?php
/**
 * Functions that are not directly called from template files
 * and cannot be grouped into another file.
 *
 * @version 2.0.0
 *
 * @package Fanoe
 */

/**
 * Load translation from languages directory.
 */
function fanoe_load_translation() {
	if ( ( ! defined( 'DOING_AJAX' ) && ! 'DOING_AJAX' ) || ! fanoe_is_login_page() || ! fanoe_is_wp_comments_post() ) {
		load_theme_textdomain( 'fanoe' );
	} // End if().
}

if ( ! function_exists( 'fanoe_is_login_page' ) ) {
	/**
	 * Check if we are on the login page
	 *
	 * @return bool true if on login page, otherwise false.
	 */
	function fanoe_is_login_page() {
		return in_array( $GLOBALS['pagenow'], [ 'wp-login.php', 'wp-register.php' ], true );
	}
} // End if().

if ( ! function_exists( 'fanoe_is_wp_comments_post' ) ) {
	/**
	 * Check if we are on the wp-comments-post.php
	 *
	 * @return bool true if on wp-comments-post.php, otherwise false.
	 */
	function fanoe_is_wp_comments_post() {
		return in_array( $GLOBALS['pagenow'], [ 'wp-comments-post.php' ], true );
	}
} // End if().

/**
 * Set the content width.
 */
function fanoe_set_content_width() {
	/**
	 * Set the content width to 751.
	 */
	$content_width = 800;

	/**
	 * Make the content width filterable.
	 *
	 * @param int $content_width Content width in pixels.
	 */
	$GLOBALS['content_width'] = apply_filters( 'fanoe_content_width', $content_width );
}

if ( ! function_exists( 'fanoe_add_theme_support' ) ) {
	/**
	 * Various add_theme_support() calls.
	 */
	function fanoe_add_theme_support() {
		/**
		 * Add theme support for automatic feed links.
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Add theme support for infinite scroll.
		 */
		add_theme_support( 'infinite-scroll', [
			'container' => 'main',
		] );

		/**
		 * Add theme support for HTML5 markup in Core elements.
		 */
		add_theme_support( 'html5', [
			'comment-list',
			'comment-form',
			'search-form',
			'gallery',
			'caption',
		] );

		/**
		 * Add theme support for post thumbnails.
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Add theme support for title tag.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Add theme support for the custom logo feature.
		 */
		add_theme_support( 'custom-logo' );
	}
} // End if().

/**
 * Enqueues scripts and styles.
 */
function fanoe_scripts_styles() {
	/**
	 * Add reply script if we are on a single view with open comments
	 * and the threaded comments feature is enabled.
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/**
	 * Add JS for sidebar button handling.
	 */
	if ( ! is_admin() ) {
		wp_enqueue_script( 'fanoe-sidebar', get_theme_file_uri( 'assets/js/bundle.js' ), [], false, true );
	}

	/**
	 * Check if SCRIPT_DEBUG is defined and enabled.
	 */
	if ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) {
		$suffix = '.css';
	} else {
		$suffix = '.min.css';
	}

	/**
	 * Check if RTL
	 */
	if ( is_rtl() ) {
		/**
		 * Enqueue RTL stylesheet.
		 */
		wp_enqueue_style( 'fanoe-style', get_theme_file_uri( "assets/css/fanoe-rtl$suffix" ) );
	} else {
		/**
		 * Enqueue default stylesheet.
		 */
		wp_enqueue_style( 'fanoe-style', get_theme_file_uri( "assets/css/fanoe$suffix" ) );
	}

}

/**
 * Register sidebar.
 */
function fanoe_register_sidebar() {
	register_sidebar( [
		'name'          => 'Sidebar',
		'description'   => '',
		'id'            => 'sidebar-1',
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	] );
}

if ( ! function_exists( 'fanoe_get_pings_number_text' ) ) {
	/**
	 * Returns string for the number of trackbacks.
	 *
	 * @param array $comments_by_type array of type separated comments.
	 *
	 * @return string Trackback number text or empty string.
	 */
	function fanoe_get_pings_number_text( $comments_by_type ) {
		/**
		 * Check if we have pings, otherwise return empty string.
		 */
		if ( $comments_by_type['pings'] ) {
			/**
			 * Save the trackback count.
			 */
			$trackback_number = count( $comments_by_type['pings'] );

			/**
			 * Build the trackback number text.
			 */
			$trackback_number_text = sprintf( /* translators: s=trackback count */
				'<a href="%s#trackbacks-title">%s</a>',
				get_permalink(),
				sprintf(
					__( 'Trackbacks: %s', 'fanoe' ),
					number_format_i18n( $trackback_number )
				)
			);

			return $trackback_number_text;
		} else {
			return '';
		}
	}
} // End if().

if ( ! function_exists( 'fanoe_get_comments_number_text' ) ) {
	/**
	 * Returns string for the number of comments.
	 *
	 * @param array $comments_by_type array of type separated comments.
	 *
	 * @return string Comments number text or empty string.
	 */
	function fanoe_get_comments_number_text( $comments_by_type ) {
		/**
		 * Check if we have comments, otherwise return empty string.
		 */
		if ( $comments_by_type['comment'] ) {
			/**
			 * Save the comment count.
			 */
			$comment_number = count( $comments_by_type['comment'] );

			/**
			 * Build the comments number text.
			 */
			$comments_number_text = sprintf( /* translators: s=comment count */
				'<a href="%s#comments-title">%s</a>',
				get_permalink(),
				sprintf(
					__( 'Comments: %s', 'fanoe' ),
					number_format_i18n( $comment_number )
				)
			);

			return $comments_number_text;
		} else {
			return '';
		}
	}
} // End if().

if ( ! function_exists( 'fanoe_post_thumbnail_caption' ) ) {
	/**
	 * Returns the post thumbnail caption.
	 *
	 * @return string Post thumbnail caption markup or empty string if no caption.
	 */
	function fanoe_get_post_thumbnail_caption() {
		/**
		 * Get the caption.
		 */
		$post_thumbnail_caption = get_the_post_thumbnail_caption();

		/**
		 * Check if we have a caption.
		 */
		if ( '' !== $post_thumbnail_caption ) {
			/**
			 * Return the caption inside a figcaption element.
			 */
			return sprintf(
				'<figcaption>%s</figcaption>',
				$post_thumbnail_caption
			);
		} // End if().

		return '';
	}
} // End if().

if ( ! function_exists( 'fanoe_get_tag_list' ) ) {
	/**
	 * Returns list of tags for a post.
	 *
	 * @return string Tag list or empty string.
	 */
	function fanoe_get_tag_list() {
		/**
		 * Get tag array.
		 */
		$tags = get_the_tags();

		/**
		 * Check if we have a tag array, otherwise return empty string.
		 */
		if ( is_array( $tags ) ) {
			/**
			 * Build the markup.
			 */
			$tags_markup = sprintf( /* translators: 1=tag label; 2=tag list */
				__( '%1$s: %2$s', 'fanoe' ),

				/**
				 * Display singular or plural label based on tag count.
				 */
				_n(
					'Tag',
					'Tags',
					count( $tags ),
					'fanoe'
				), /* translators: term delimiter */
				get_the_tag_list( '', __( ', ', 'fanoe' ) )
			);

			return $tags_markup;
		} else {
			return '';
		}
	}
} // End if().

/**
 * Remove more hash from read more link.
 *
 * @param string $link <a> element with more link.
 *
 * @return string <a> element with modified read more link.
 */
function fanoe_remove_more_jump_link( $link ) {
	/**
	 * Get position of #more hash.
	 */
	$offset = strpos( $link, '#more-' );

	/**
	 * Check if we have a position value.
	 */
	if ( $offset ) {
		/**
		 * Get the end of the URL.
		 */
		$end = strpos( $link, '"', $offset );
	}

	/**
	 * Check if we have an end.
	 */
	if ( $end ) {
		/**
		 * Replace the #more hash with an empty string.
		 */
		$link = substr_replace( $link, '', $offset, $end - $offset );
	}

	return $link;
}
