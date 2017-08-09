<?php

add_action( 'after_setup_theme', 'fanoe_setup' );
if ( ! isset( $content_width ) ) {
	$content_width = 800;
}

if ( ! function_exists( 'fanoe_setup' ) ):
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which runs
	 * before the init hook. The init hook is too late for some features, such as indicating
	 * support post thumbnails.
	 *
	 * To override fanoe_setup() in a child theme, add your own fanoe_setup to your child theme's
	 * functions.php file.
	 *
	 */
	function fanoe_setup() {

		/* Make Fanoe available for translation.
		 * Translations can be added to the /languages/ directory.
		 * If you're building a theme based on Fanoe, use a find and replace
		 * to change 'fanoe' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'fanoe', get_template_directory() . '/languages' );
		$locale      = get_locale();
		$locale_file = get_template_directory() . "/languages/$locale.php";
		if ( is_readable( $locale_file ) ) {
			require_once( $locale_file );
		}

		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style();

		// Add default posts and comments RSS feed links to <head>.
		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'infinite-scroll', array(
			'container' => 'main'
		) );

		// Add support for a variety of post formats
		add_theme_support( 'post-formats', array(
			'aside',
			'link',
			'gallery',
			'status',
			'quote',
			'image',
			'video',
			'audio',
			'chat'
		) );

		$args = array(
			'flex-width'  => true,
			'flex-height' => true,
			'uploads'     => true,
		);
		add_theme_support( 'custom-header', $args );


		// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
		add_theme_support( 'post-thumbnails' );

		add_theme_support( 'custom-background' );
		add_theme_support( 'title-tag' );

	}
endif; // fanoe_setup

/**
 * Enqueues scripts and styles for front-end.
 *
 */
function fanoe_scripts_styles() {
	global $wp_styles;

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/*
	 * Adds JavaScript for handling the navigation menu hide-and-show behavior.
	 */
	if ( ! is_admin() ) {
		wp_enqueue_script( 'fanoe-sidebar', get_template_directory_uri() . '/js/sidebar.js', array( 'jquery' ), false, true );
	}


	wp_enqueue_style( 'fanoe-fonts', '//fonts.googleapis.com/css?family=Source+Code+Pro|Libre+Baskerville:400,400italic,700', array(), null );

	/*
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style( 'fanoe-style', get_stylesheet_uri(), array(), null );
}

add_action( 'wp_enqueue_scripts', 'fanoe_scripts_styles' );

function fanoe_menus() {
	register_nav_menus(
		array(
			'sidebar-menu' => __( 'Sidebar Menu', 'fanoe' ),
		)
	);
}

add_action( 'init', 'fanoe_menus' );

if ( ! function_exists( 'fanoe_continue_reading_link' ) ) {
	/**
	 * Returns a "Continue Reading" link for excerpts
	 */
	function fanoe_continue_reading_link() {
		return ' <a href="' . esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'fanoe' ) . '</a>';
	}
} // fanoe_continue_reading_link

function fanoe_remove_more_jump_link( $link ) {
	$offset = strpos( $link, '#more-' );
	if ( $offset ) {
		$end = strpos( $link, '"', $offset );
	}
	if ( $end ) {
		$link = substr_replace( $link, '', $offset, $end - $offset );
	}

	return $link;
}

add_filter( 'the_content_more_link', 'fanoe_remove_more_jump_link' );

/**
 * Get the width of the post-thumbnail, to check if it should be displayed fullwidth or not.
 **/
function fanoe_get_size_of_post_thumbnail() {
	global $post;
	$image_data  = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "full" );
	$image_width = $image_data[1];

	return $image_width;
}

function fanoe_the_post_thumbnail() {
	?>
	<?php $fanoe_get_size_of_post_thumbnail = fanoe_get_size_of_post_thumbnail() ?>
	<?php if ( has_post_thumbnail() ) : ?>
		<?php if ( $fanoe_get_size_of_post_thumbnail < 800 ) : ?>
			<figure class="post-thumb-container">
				<a href="<?php the_permalink(); ?>"
				   title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'fanoe' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php the_post_thumbnail(); ?></a>
				<?php echo fanoe_post_thumbnail_caption(); ?>
			</figure>
		<?php else: ?>
			<figure class="post-thumb-container-large">
				<a href="<?php the_permalink(); ?>"
				   title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'fanoe' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php the_post_thumbnail( 'large' ); ?></a>
				<?php echo fanoe_post_thumbnail_caption(); ?>
			</figure>
		<?php endif; ?>
	<?php endif; ?>

<?php }

function fanoe_post_thumbnail_caption() {
	global $post;

	$thumbnail_id    = get_post_thumbnail_id( $post->ID );
	$thumbnail_image = get_posts( array( 'p' => $thumbnail_id, 'post_type' => 'attachment' ) );
	if ( $thumbnail_image && isset( $thumbnail_image[0] ) ) {
		if ( $thumbnail_image[0]->post_excerpt != "" ) {
			echo "<figcaption>";
			echo $thumbnail_image[0]->post_excerpt;
			echo "</figcaption>";
		}
	}
}

function fanoe_footer_meta() {
	?>
	<?php $show_sep = false; ?>
	<?php if ( is_object_in_taxonomy( get_post_type(), 'category' ) ) : // Hide category text when not supported ?>
		<?php
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'fanoe' ) );
		if ( $categories_list ):
			?>
			<span class="cat-links">
                <?php printf( __( '<span class="%1$s">Posted in</span> %2$s', 'fanoe' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );
                $show_sep = true; ?>
            </span>
		<?php endif; // End if categories ?>
	<?php endif; // End if is_object_in_taxonomy( get_post_type(), 'category' )
	?>

	<?php if ( is_object_in_taxonomy( get_post_type(), 'post_tag' ) ) : // Hide tag text when not supported ?>
		<?php
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ', ', 'fanoe' ) );
		if ( $tags_list ):
			if ( $show_sep ) : ?>
				<span class="sep"> | </span>
			<?php endif; // End if $show_sep
			?>
			<span class="tag-links">
                <?php printf( __( '<span class="%1$s">Tagged</span> %2$s', 'fanoe' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list );
                $show_sep = true; ?>
            </span>
		<?php endif; // End if $tags_list ?>
	<?php endif; // End if is_object_in_taxonomy( get_post_type(), 'post_tag' )
	?>
	<span> <?php _e( 'by', 'fanoe' ); ?><?php the_author(); ?></span>
	<?php edit_post_link( __( 'Edit', 'fanoe' ), '<span class="edit-link">| ', '</span>' ); ?>
<?php }


if ( ! function_exists( 'fanoe_comment' ) ) {
	/**
	 * Template for comments and pingbacks.
	 *
	 * To override this walker in a child theme without modifying the comments template
	 * simply create your own fanoe_comment(), and that function will be used instead.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 */
	function fanoe_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
				// Display trackbacks differently than normal comments.
				?>
				<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
				<p><?php _e( 'Trackback:', 'fanoe' ); ?><?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'fanoe' ), '<span class="edit-link">', '</span>' ); ?></p>
				<?php
				break;
			default :
				// Proceed with normal comments.
				global $post;
				?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<article id="comment-<?php comment_ID(); ?>" class="comment">
					<header class="comment-meta comment-author vcard">
						<?php
						echo get_avatar( $comment, 44 );
						printf( '<cite class="fn">%1$s %2$s</cite>',
							get_comment_author_link(),
							// If current post author is also comment author, make it known visually.
							( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'fanoe' ) . '</span>' : ''
						);
						printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
							esc_url( get_comment_link( $comment->comment_ID ) ),
							get_comment_time( 'c' ),
							/* translators: 1: date, 2: time */
							sprintf( __( '%1$s @ %2$s', 'fanoe' ), get_comment_date(), get_comment_time() )
						);
						?>
					</header><!-- .comment-meta -->

					<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'fanoe' ); ?></p>
					<?php endif; ?>

					<section class="comment-content comment">
						<?php comment_text(); ?>
						<?php edit_comment_link( __( 'Edit', 'fanoe' ), '<p class="edit-link">', '</p>' ); ?>
					</section><!-- .comment-content -->

					<div class="reply">
						<?php comment_reply_link( array_merge( $args, array(
							'reply_text' => __( 'Reply', 'fanoe' ),
							'after'      => ' <span>&darr;</span>',
							'depth'      => $depth,
							'max_depth'  => $args['max_depth']
						) ) ); ?>
					</div><!-- .reply -->
				</article><!-- #comment-## -->
				<?php
				break;
		endswitch; // end comment_type check
	}
}

if ( function_exists( 'register_sidebar' ) ) {

	register_sidebar( array(
		'name'          => 'Sidebar',
		'description'   => '',
		'id'            => 'sidebar-1',
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	) );
}

//Kommentaranzahl in fanoe_comment_count speichern

function fanoe_comment_count() {
	global $post;
	$thePostID = $post->ID;
	global $wpdb;
	$count     = "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_type = ' '
AND comment_post_ID = $thePostID AND comment_approved='1'";
	$co_number = $wpdb->get_var( $count );
	if ( $co_number == 0 ) {
	} elseif ( $co_number == 1 ) {
		echo $co_number . __( ' Comment', 'fanoe' );
	} else {
		echo $co_number . __( ' Comments', 'fanoe' );
	}
}


//Trackbackzahl in fanoe_trackback_count speichern
function fanoe_trackback_count() {
	global $post;
	$thePostID = $post->ID;
	global $wpdb;
	$count     = "SELECT COUNT(*) FROM $wpdb->comments
WHERE comment_type != ' '
AND comment_post_ID = $thePostID AND comment_approved='1'";
	$tb_number = $wpdb->get_var( $count );
	if ( $tb_number == 0 ) {
	} elseif ( $tb_number == 1 ) {
		echo $tb_number . __( ' Trackback', 'fanoe' );
	} else {
		echo $tb_number . __( ' Trackbacks', 'fanoe' );
	}
}

//Customizer
function fanoe_customize_register( $wp_customize ) {
	$colors   = array();
	$colors[] = array(
		'slug'    => 'design_color',
		'default' => '#27ae60',
		'label'   => __( 'Main Color of the Design', 'fanoe' )
	);
	foreach ( $colors as $color ) {
		// SETTINGS
		$wp_customize->add_setting(
			$color['slug'], array(
				'default'           => $color['default'],
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_hex_color'
			)
		);
		// CONTROLS
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$color['slug'],
				array(
					'label'    => $color['label'],
					'section'  => 'colors',
					'settings' => $color['slug']
				)
			)
		);

	}
	$contents   = array();
	$contents[] = array(
		'slug'    => 'share_btns_blogview',
		'default' => 1,
		'label'   => __( 'Share Buttons in the blog view', 'fanoe' )
	);
	$contents[] = array(
		'slug'    => 'share_btns_singleview',
		'default' => 1,
		'label'   => __( 'Share Buttons in the single view', 'fanoe' )
	);
	$contents[] = array(
		'slug'    => 'author_bio',
		'default' => 1,
		'label'   => __( 'Diplay the Author Bio in the single view also on a single-author blog.', 'fanoe' )
	);
	foreach ( $contents as $content ) {
		$wp_customize->add_setting( $content['slug'], array(
			'default'           => $content['default'],
			'sanitize_callback' => 'fanoe_sanitize_checkbox'
		) );

		$wp_customize->add_control( $content['slug'], array(
			'settings' => $content['slug'],
			'label'    => $content['label'],
			'section'  => 'content',
			'type'     => 'checkbox',
		) );
	}
	$backgrounds   = array();
	$backgrounds[] = array(
		'slug'    => 'background_size',
		'default' => 'standard',
		'label'   => __( 'Change the Size of the Header Background Image', 'fanoe' )
	);
	foreach ( $backgrounds as $background ) {
		// SETTINGS
		$wp_customize->add_setting(
			$background['slug'], array(
				'default'           => $background['default'],
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'fanoe_sanitize_radio'
			)
		);
		// CONTROLS
		$wp_customize->add_control( $background['slug'], array(
			'label'    => $background['label'],
			'section'  => 'header_image',
			'settings' => $background['slug'],
			'type'     => 'radio',
			'choices'  => array(
				'standard' => 'Standard',
				'cover'    => __( 'The Image fills out the whole header', 'fanoe' ),
				'height'   => __( '100% Height, Auto Width', 'fanoe' ),
			),
		) );
	}

	class fanoe_Customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';

		public function render_content() {
			?>

			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<textarea rows="5"
				          style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label>

			<?php
		}
	}

	class fanoe_Customize_Input_Control extends WP_Customize_Control {
		public $type = 'input';

		public function render_content() {
			?>

			<label>
				<span class="customize-control-title"><?php echo $this->label ?></span>
				<input type="text" value="<?php echo htmlspecialchars( get_theme_mod( $this->value() ) ); ?>"
				       style="width:100%;" <?php $this->link(); ?>></input>
			</label>

			<?php
		}
	}

	$wp_customize->add_setting( 'custom_css', array(
		'default'           => '',
		'sanitize_callback' => 'fanoe_sanitize_custom_css'
	) );
	$wp_customize->add_control( new fanoe_Customize_Textarea_Control( $wp_customize, 'custom_css', array(
		'label'    => __( 'Custom CSS', 'fanoe' ),
		'section'  => 'css',
		'settings' => 'custom_css',
	) ) );
	$wp_customize->add_section( 'css', array(
		'title' => __( 'CSS', 'fanoe' ),
	) );
	$wp_customize->add_setting( 'copyright', array(
		'default'           => '',
		'sanitize_callback' => 'fanoe_sanitize_input_with_html'
	) );
	$wp_customize->add_control( new fanoe_Customize_Input_Control( $wp_customize, 'copyright', array(
		'label'    => __( 'Copyright', 'fanoe' ),
		'section'  => 'content',
		'settings' => 'copyright',
	) ) );
	$wp_customize->add_setting( 'sidebar_btn', array(
		'default'           => '',
		'sanitize_callback' => 'fanoe_sanitize_input_without_html'
	) );
	$wp_customize->add_control( new fanoe_Customize_Input_Control( $wp_customize, 'sidebar_btn', array(
		'label'    => __( 'Replace the Sidebar Button with your text', 'fanoe' ),
		'section'  => 'content',
		'settings' => 'sidebar_btn',
	) ) );
	$wp_customize->add_section( 'content', array(
		'title' => __( 'Content', 'fanoe' ),
	) );
}

add_action( 'customize_register', 'fanoe_customize_register' );

?>
<?php // Custom CSS for Link Colors
function fanoe_insert_custom() {
	$text_color   = get_header_textcolor();
	$header_image = get_header_image();
	$design_color = get_theme_mod( 'design_color' );
	?>
	<style>::selection {
			background: <?php echo $design_color ; ?>;
			color: #fff;
		}

		::-moz-selection {
			background: <?php echo $design_color ; ?>;
			color: #fff;
		}

		a, .format-status header h1 a:hover, .format-status header h1 a:active, .format-status header h1 a:focus, .site-title a:hover, .site-title a:active, .site-title a:focus {
			color: <?php echo $design_color ; ?>;
		}

		a:focus, a:active, a:hover, .format-status, input[type=reset]:hover, input[type=submit]:hover, input[type=reset]:active, input[type=submit]:active, input[type=reset]:focus, input[type=submit]:focus {
			background: <?php echo $design_color ; ?>;
		}

		input[type=text]:hover, input[type=password]:hover, input[type=email]:hover, input[type=url]:hover, input[type=number]:hover, textarea:hover, input[type=text]:focus, input[type=password]:focus, input[type=email]:focus, input[type=url]:focus, input[type=number]:focus, textarea:focus {
			border-color: <?php echo $design_color ; ?>
		}

		.bypostauthor, .active-sidebar #sidebar {
			border-left-color: <?php echo $design_color ; ?>
		}

		<?php echo get_theme_mod( 'custom_css', 'default_value' );?>
	</style>
	<style type="text/css">
		<?php
			// Has the text been hidden?
			if ( ! display_header_text() ) :
		?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px 1px 1px 1px); /* IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}

		#branding {
			height: 122px;
		}

		<?php
				if ( empty( $header_image ) ) :
		?>
		.site-header .home-link {
			min-height: 0;
		}

		#branding {
			height: 0px;
		}

		<?php
				endif;

			// If the user has set a custom color for the text, use that.
			elseif ( $text_color != get_theme_support( 'custom-header', 'default-text-color' ) ) :
		?>
		.site-title a,
		.site-description {
			color: # <?php echo esc_attr( $text_color ); ?>;
		}

		<?php endif; ?>
	</style>
	<?php

}

add_action( 'wp_head', 'fanoe_insert_custom' );

function fanoe_sanitize_radio( $value ) {
	return $value;
}

function fanoe_sanitize_checkbox( $value ) {
	return $value;
}

function fanoe_sanitize_custom_css( $value ) {
	// Some people put weird stuff in their CSS, KSES tends to be greedy
	$css = str_replace( '<=', '&lt;=', $value );
	// Why KSES instead of strip_tags?  Who knows?
	$css = wp_kses_split( $css, array(), array() );
	$css = str_replace( '&gt;', '>', $css ); // kses replaces lone '>' with &gt;
	// Why both KSES and strip_tags?  Because we just added some '>'.
	$css = strip_tags( $css );

	return $css;
}

function fanoe_sanitize_input_with_html( $value ) {
	return $value;
}

function fanoe_sanitize_input_without_html( $value ) {
	$value = strip_tags( $value );

	return $value;
}
