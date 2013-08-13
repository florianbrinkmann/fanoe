<?php
	
add_action( 'after_setup_theme', 'fanoe_setup' );
if ( ! isset( $content_width ) ) $content_width = 800;

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
	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
	    require_once( $locale_file );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// Add support for a variety of post formats
	add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image', 'video', 'audio', 'chat' ) );
	
	$args = array(
		'flex-width'    => true,
		'flex-height'    => true,
		'uploads'       => true,
	);
	add_theme_support( 'custom-header', $args );


	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	add_theme_support( 'post-thumbnails' );
	
	add_theme_support( 'custom-background' );
	
	
}
endif; // fanoe_setup


/*
 * Print the <title> tag based on what is being viewed.
 */
function fanoe_custom_wp_title($title) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	$site_description = get_bloginfo( 'description' );

	$filtered_title = $title . get_bloginfo( 'name' );
	$filtered_title .= ( ! empty( $site_description ) && ( is_home() || is_front_page() ) ) ? ' | ' . $site_description: '';
	$filtered_title .= ( 2 <= $paged || 2 <= $page ) ? ' | ' . sprintf( __( 'Page %s', 'fanoe' ), max( $paged, $page ) ) : '';

	return $filtered_title;
}
add_filter( 'wp_title', 'fanoe_custom_wp_title');
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
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/*
	 * Adds JavaScript for handling the navigation menu hide-and-show behavior.
	 */
	 if(!is_admin())
	 wp_enqueue_script( 'fanoe-sidebar', get_template_directory_uri() . '/js/sidebar.js', array( 'jquery' ), false, true );
	 
    	 

	
	wp_enqueue_style( 'fanoe-fonts', 'http://fonts.googleapis.com/css?family=Source+Code+Pro|Libre+Baskerville:400,400italic,700', array(), null );

	/*
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style( 'fanoe-style', get_stylesheet_uri(), array(), null );
	
	wp_enqueue_style( 'fanoe-ie', get_template_directory_uri() . '/conditional/lte-ie7.css');
	wp_style_add_data( 'fanoe-ie', 'conditional', 'lt IE 8' );

}
add_action( 'wp_enqueue_scripts', 'fanoe_scripts_styles' );

// add ie conditional html5 shim to header
if(!is_admin()){
	function fanoe_add_ie_conditional () {
		global $is_IE;
		if ($is_IE){
			echo '<!--[if lt IE 9]>';
			echo '<script src="'.get_template_directory_uri() .'/js/html5.js"></script>';
			echo '<script src="'.get_template_directory_uri() .'/conditional/matchmedia.js"></script>';
			echo '<![endif]-->';
		}
	}
	add_action('wp_head', 'fanoe_add_ie_conditional');
}
	

function fanoe_menus() {
  register_nav_menus(
    array(
      'sidebar-menu' => __( 'Sidebar Menu', 'fanoe' ),
    )
  );
}
add_action( 'init', 'fanoe_menus' );
/**
 * Sets the post excerpt length to 40 words.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 */
function fanoe_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'fanoe_excerpt_length' );

if ( ! function_exists( 'fanoe_continue_reading_link' ) ) :
/**
 * Returns a "Continue Reading" link for excerpts
 */
function fanoe_continue_reading_link() {
	return ' <a href="'. esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'fanoe' ) . '</a>';
}
endif; // fanoe_continue_reading_link

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and fanoe_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function fanoe_auto_excerpt_more( $more ) {
	return ' &hellip;' . fanoe_continue_reading_link();
}
add_filter( 'excerpt_more', 'fanoe_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function fanoe_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= fanoe_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'fanoe_custom_excerpt_more' );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function fanoe_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'fanoe_page_menu_args' );


function fanoe_remove_more_jump_link($link) { 
$offset = strpos($link, '#more-');
if ($offset) {
$end = strpos($link, '"',$offset);
}
if ($end) {
$link = substr_replace($link, '', $offset, $end-$offset);
}
return $link;
}
add_filter('the_content_more_link', 'fanoe_remove_more_jump_link');




if ( ! function_exists( 'fanoe_comment' ) ) :
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
		<p><?php _e( 'Trackback:', 'fanoe' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'fanoe' ), '<span class="edit-link">', '</span>' ); ?></p>
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
						sprintf( __( '%1$s @ %2$s', 'fanoe' ), get_comment_date(__('F j, Y', 'fanoe')), get_comment_time(__('g:i a', 'fanoe')) )
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
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'fanoe' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;



// Customize Comment Form
	function fanoe_fields($fields) {
	if ( isset($req) && isset($commenter) && isset($aria_req)) {
	$fields['author'] = '<p class="comment-form-author">' . '<label for="author">' . __( 'Name*', 'fanoe' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
	                    '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>';
	}
	if ( isset($req) && isset($commenter) && isset($aria_req)) {
	$fields['email'] = '<p class="comment-form-email"><label for="email">' . __( 'Email*', 'fanoe' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
	                    '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>';
	}
	if ( isset($req) && isset($commenter) && isset($aria_req)) {
	$fields['url'] = '<p class="comment-form-url"><label for="url">' . __( 'Website', 'fanoe' ) . '</label>' .
	                    '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>';
	}
	return $fields;
	
	}
	add_filter('comment_form_default_fields','fanoe_fields');
?>
<?php



if ( function_exists('register_sidebar') ) {

register_sidebar(array('name' => 'Sidebar',
                       'description' => '',
                       'before_widget' => '<div class="widget">',
                       'after_widget' => '</div>',
                       'before_title' => '<h4>',
                       'after_title' => '</h4>'));
}


add_filter('gallery_style', create_function('$a', 'return "
	<div class=\'gallery\'>";'));
	

//Kommentaranzahl in fanoe_comment_count speichern

function fanoe_comment_count() { global $post; $thePostID = $post->ID; global $wpdb;
$count = "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_type = ' '
AND comment_post_ID = $thePostID AND comment_approved='1'"; $co_number = $wpdb->get_var($count);
if ($co_number == 0) {}
elseif ($co_number == 1) {echo $co_number .  __(' Comment', 'fanoe');} 
else {echo $co_number .  __(' Comments', 'fanoe');}
}



//Trackbackzahl in fanoe_trackback_count speichern
function fanoe_trackback_count() 
{ global $post;
$thePostID = $post->ID;global $wpdb;$count = "SELECT COUNT(*) FROM $wpdb->comments
WHERE comment_type != ' '
AND comment_post_ID = $thePostID AND comment_approved='1'"; $tb_number = $wpdb->get_var($count);
if ($tb_number == 0) {}
elseif ($tb_number == 1) {echo $tb_number . __(' Trackback', 'fanoe');} 
else {echo $tb_number .  __(' Trackbacks', 'fanoe');}  }



//Social Media Widget
class Fanoe_Social_Media_Widget extends WP_Widget 
{
	public function __construct() 
	{
		parent::__construct(
			'fanoe_social_media_widget',
			'Social Media Widget',
			array(
				'description' => __('Here you can add your social media channels.', 'fanoe')
			)
	    );
	}

 	public function form($instance) 
	{
		$defaults = array(
			'title' => 'Social Media',
			'google_plus' => '', 
			'twitter' => '',
			'facebook' => '',
			'tumblr' => '',
			'pinterest' => '',
			'dribbble' => '',
			'flickr' => '',
			'instagram' => '',
			'picasa' => '',
			'deviantart' => '',
			'youtube' => '',
			'vimeo' => '',
			'soundcloud' => '',
			'lastfm' => '',
			'foursquare' => '',
			'appnet' => '',
			'github' => '',
			'wordpress' => '',
			'xing' => '',
			'linkedin' => '',
			'behance' => '',
			'rss' => ''
	    );
		$instance = wp_parse_args((array)$instance, $defaults);

	    $title = $instance['title'];
	    $google_plus = $instance['google_plus'];
	    $twitter = $instance['twitter'];
		$facebook = $instance['facebook'];
		$tumblr = $instance['tumblr'];
		$pinterest = $instance['pinterest'];
		$dribbble = $instance['dribbble'];
		$flickr = $instance['flickr'];
		$instagram = $instance['instagram'];
		$picasa = $instance['picasa'];
		$deviantart = $instance['deviantart'];
		$youtube = $instance['youtube'];
		$vimeo = $instance['vimeo'];
		$soundcloud = $instance['soundcloud'];
		$lastfm = $instance['lastfm'];
		$foursquare = $instance['foursquare'];
		$appnet = $instance['appnet'];
		$github = $instance['github'];
		$wordpress = $instance['wordpress'];
		$xing = $instance['xing'];
		$linkedin = $instance['linkedin'];
		$behance = $instance['behance'];
		$rss = $instance['rss'];
	    ?>
        <p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __('Title:', 'fanoe'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('google_plus'); ?>"><?php echo 'Google Plus:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('google_plus'); ?>" name="<?php echo $this->get_field_name('google_plus'); ?>" type="text" value="<?php echo esc_attr($google_plus); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('twitter'); ?>"><?php echo 'Twitter:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo esc_attr($twitter); ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id('facebook'); ?>"><?php echo 'Facebook:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo esc_attr($facebook); ?>" />
		</p>
         <p>
			<label for="<?php echo $this->get_field_id('tumblr'); ?>"><?php echo 'Tumblr:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('tumblr'); ?>" name="<?php echo $this->get_field_name('tumblr'); ?>" type="text" value="<?php echo esc_attr($tumblr); ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id('pinterest'); ?>"><?php echo 'Pinterest:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('pinterest'); ?>" name="<?php echo $this->get_field_name('pinterest'); ?>" type="text" value="<?php echo esc_attr($pinterest); ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id('dribbble'); ?>"><?php echo 'Dribbble:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('dribbble'); ?>" name="<?php echo $this->get_field_name('dribbble'); ?>" type="text" value="<?php echo esc_attr($dribbble); ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id('flickr'); ?>"><?php echo 'Flickr:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('flickr'); ?>" name="<?php echo $this->get_field_name('flickr'); ?>" type="text" value="<?php echo esc_attr($flickr); ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id('instagram'); ?>"><?php echo 'Instagram:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>" name="<?php echo $this->get_field_name('instagram'); ?>" type="text" value="<?php echo esc_attr($instagram); ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id('picasa'); ?>"><?php echo 'Picasa:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('picasa'); ?>" name="<?php echo $this->get_field_name('picasa'); ?>" type="text" value="<?php echo esc_attr($picasa); ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id('deviantart'); ?>"><?php echo 'Deviantart:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('deviantart'); ?>" name="<?php echo $this->get_field_name('deviantart'); ?>" type="text" value="<?php echo esc_attr($deviantart); ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id('youtube'); ?>"><?php echo 'YouTube:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" name="<?php echo $this->get_field_name('youtube'); ?>" type="text" value="<?php echo esc_attr($youtube); ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id('vimeo'); ?>"><?php echo 'Vimeo:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('vimeo'); ?>" name="<?php echo $this->get_field_name('vimeo'); ?>" type="text" value="<?php echo esc_attr($vimeo); ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id('soundcloud'); ?>"><?php echo 'Soundcloud:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('soundcloud'); ?>" name="<?php echo $this->get_field_name('soundcloud'); ?>" type="text" value="<?php echo esc_attr($soundcloud); ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id('lastfm'); ?>"><?php echo 'last.fm:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('lastfm'); ?>" name="<?php echo $this->get_field_name('lastfm'); ?>" type="text" value="<?php echo esc_attr($lastfm); ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id('foursquare'); ?>"><?php echo 'Foursquare:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('foursquare'); ?>" name="<?php echo $this->get_field_name('foursquare'); ?>" type="text" value="<?php echo esc_attr($foursquare); ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id('appnet'); ?>"><?php echo 'app.net:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('appnet'); ?>" name="<?php echo $this->get_field_name('appnet'); ?>" type="text" value="<?php echo esc_attr($appnet); ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id('github'); ?>"><?php echo 'Github:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('github'); ?>" name="<?php echo $this->get_field_name('github'); ?>" type="text" value="<?php echo esc_attr($github); ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id('wordpress'); ?>"><?php echo 'WordPress:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('wordpress'); ?>" name="<?php echo $this->get_field_name('wordpress'); ?>" type="text" value="<?php echo esc_attr($wordpress); ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id('xing'); ?>"><?php echo 'Xing:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('xing'); ?>" name="<?php echo $this->get_field_name('xing'); ?>" type="text" value="<?php echo esc_attr($xing); ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php echo 'LinkedIn:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" type="text" value="<?php echo esc_attr($linkedin); ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id('behance'); ?>"><?php echo 'Behance:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('behance'); ?>" name="<?php echo $this->get_field_name('behance'); ?>" type="text" value="<?php echo esc_attr($behance); ?>" />
	   </p>
       <p>
			<label for="<?php echo $this->get_field_id('rss'); ?>"><?php echo 'RSS Feed:'; ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('rss'); ?>" name="<?php echo $this->get_field_name('rss'); ?>" type="text" value="<?php echo esc_attr($rss); ?>" />
		</p>
		<?php
	}
	
	public function update($new_instance, $old_instance)
	{
		$instance = array();
		 
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['google_plus'] = strip_tags($new_instance['google_plus']);
		$instance['twitter'] = strip_tags($new_instance['twitter']);
		$instance['facebook'] = strip_tags($new_instance['facebook']);
		$instance['tumblr'] = strip_tags($new_instance['tumblr']);
		$instance['pinterest'] = strip_tags($new_instance['pinterest']);
		$instance['dribbble'] = strip_tags($new_instance['dribbble']);
		$instance['flickr'] = strip_tags($new_instance['flickr']);
		$instance['instagram'] = strip_tags($new_instance['instagram']);
		$instance['picasa'] = strip_tags($new_instance['picasa']);
		$instance['deviantart'] = strip_tags($new_instance['deviantart']);
		$instance['youtube'] = strip_tags($new_instance['youtube']);
		$instance['vimeo'] = strip_tags($new_instance['vimeo']);
		$instance['soundcloud'] = strip_tags($new_instance['soundcloud']);
		$instance['lastfm'] = strip_tags($new_instance['lastfm']);
		$instance['foursquare'] = strip_tags($new_instance['foursquare']);
		$instance['appnet'] = strip_tags($new_instance['appnet']);
		$instance['github'] = strip_tags($new_instance['github']);
		$instance['wordpress'] = strip_tags($new_instance['wordpress']);
		$instance['xing'] = strip_tags($new_instance['xing']);
		$instance['linkedin'] = strip_tags($new_instance['linkedin']);
		$instance['behance'] = strip_tags($new_instance['behance']);
		$instance['rss'] = strip_tags($new_instance['rss']);
 
		return $instance;
	}

	public function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$google_plus = $instance['google_plus'];
		$twitter = $instance['twitter'];
		$facebook = $instance['facebook'];
		$tumblr = $instance['tumblr'];
		$pinterest = $instance['pinterest'];
		$dribbble = $instance['dribbble'];
		$flickr = $instance['flickr'];
		$instagram = $instance['instagram'];
		$picasa = $instance['picasa'];
		$deviantart = $instance['deviantart'];
		$youtube = $instance['youtube'];
		$vimeo = $instance['vimeo'];
		$soundcloud = $instance['soundcloud'];
		$lastfm = $instance['lastfm'];
		$foursquare = $instance['foursquare'];
		$appnet = $instance['appnet'];
		$github = $instance['github'];
		$wordpress = $instance['wordpress'];
		$xing = $instance['xing'];
		$linkedin = $instance['linkedin'];
		$behance = $instance['behance'];
		$rss = $instance['rss'];
 
		echo $before_widget;
		 
		if(!empty($title))
		{
			echo $before_title . $title . $after_title;
		}
		 
		global $wpdb;

		echo "<ul class='social'>";
		if(!empty($google_plus)){
			echo "<li><a class='icon-gplus' title='Google Plus' href='".$google_plus ."' rel='publisher'></a></li>";			
		}
		if(!empty($twitter)){
			echo "<li><a class='icon-twitter' title='Twitter' href='".$twitter ."'></a></li>";			
		}
		if(!empty($facebook)){
			echo "<li><a class='icon-facebook' title='Facebook' href='".$facebook ."'></a></li>";			
		}
		if(!empty($tumblr)){
			echo "<li><a class='icon-tumblr' title='Tumblr' href='".$tumblr ."'></a></li>";			
		}
		if(!empty($pinterest)){
			echo "<li><a class='icon-pinterest' title='Pinterest' href='".$pinterest ."'></a></li>";			
		}
		if(!empty($dribbble)){
			echo "<li><a class='icon-dribbble' title='dribbble' href='".$dribbble ."'></a></li>";			
		}
		if(!empty($flickr)){
			echo "<li><a class='icon-flickr' title='Flickr' href='".$flickr ."'></a></li>";			
		}
		if(!empty($instagram)){
			echo "<li><a class='icon-instagram' title='Instagram' href='".$instagram ."'></a></li>";			
		}
		if(!empty($picasa)){
			echo "<li><a class='icon-picasa' title='Picasa' href='".$picasa ."'></a></li>";			
		}
		if(!empty($deviantart)){
			echo "<li><a class='icon-deviantart' title='Deviantart' href='".$deviantart ."'></a></li>";			
		}
		if(!empty($youtube)){
			echo "<li><a class='icon-youtube' title='YouTube' href='".$youtube ."'></a></li>";			
		}
		if(!empty($vimeo)){
			echo "<li><a class='icon-vimeo' title='Vimeo' href='".$vimeo ."'></a></li>";			
		}
		if(!empty($soundcloud)){
			echo "<li><a class='icon-soundcloud' title='Soundcloud' href='".$soundcloud ."'></a></li>";			
		}
		if(!empty($lastfm)){
			echo "<li><a class='icon-lastfm' title='last.fm' href='".$lastfm ."'></a></li>";			
		}
		if(!empty($foursquare)){
			echo "<li><a class='icon-foursquare' title='Foursquare' href='".$foursquare ."'></a></li>";			
		}
		if(!empty($appnet)){
			echo "<li><a class='icon-appnet' title='app.net' href='".$appnet ."'></a></li>";			
		}
		if(!empty($github)){
			echo "<li><a class='icon-github-circled' title='Github' href='".$github ."'></a></li>";			
		}
		if(!empty($wordpress)){
			echo "<li><a class='icon-wordpress' title='WordPress' href='".$wordpress ."'></a></li>";			
		}
		if(!empty($xing)){
			echo "<li><a class='icon-xing' title='Xing' href='".$xing ."'></a></li>";			
		}
		if(!empty($linkedin)){
			echo "<li><a class='icon-linkedin' title='LinkedIn' href='".$linkedin ."'></a></li>";			
		}
		if(!empty($behance)){
			echo "<li><a class='icon-behance' title='Behance' href='".$behance ."'></a></li>";			
		}
		if(!empty($rss)){
			echo "<li><a class='icon-feed' title='RSS Feed' href='".$rss ."'></a></li>";			
		}
		
		echo "</ul>";
		 
		echo $after_widget;
	}
}
// register Fanoe_Social_Media_Widget
function register_fanoe_social_media_widget() {
    register_widget( 'Fanoe_Social_Media_Widget' );
}
add_action( 'widgets_init', 'register_fanoe_social_media_widget' );



//Galerie 

function fanoe_my_own_gallery($output, $attr) {
    global $post;

    static $instance = 0;
    $instance++;


    /**
     *  will remove this since we don't want an endless loop going on here
     */
    // Allow plugins/themes to override the default gallery template.
    //$output = apply_filters('post_gallery', '', $attr);

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'dl',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 0,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => ''
    ), $attr));

    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';

    if ( !empty($include) ) {
        $include = preg_replace( '/[^0-9,]+/', '', $include );
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) )
        return '';

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

    $itemtag = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $columns = intval($columns);
    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    $float = is_rtl() ? 'right' : 'left';

    $selector = "gallery-{$instance}";

    $gallery_style = $gallery_div = '';
    if ( apply_filters( 'use_default_gallery_style', true ) )
        /**
         * this is the css you want to remove
         *  #1 in question
         */
        /*
        $gallery_style = "
        <style type='text/css'>
            #{$selector} {
                margin: auto;
            }
            #{$selector} .gallery-item {
                float: {$float};
                margin-top: 10px;
                text-align: center;
                width: {$itemwidth}%;
            }
            #{$selector} img {
                border: 2px solid #cfcfcf;
            }
            #{$selector} .gallery-caption {
                margin-left: 0;
            }
        </style>
        <!-- see gallery_shortcode() in wp-includes/media.php -->";
        */
    $size_class = sanitize_html_class( $size );
    $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
    $output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

    $i = 0;
    foreach ( $attachments as $id => $attachment ) {
        $link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);

        $output .= "<{$itemtag} class='gallery-item'>";
        $output .= "
            <{$icontag} class='gallery-icon'>
                $link
            </{$icontag}>";
        /*
         * This is the caption part so i'll comment that out
         * #2 in question
         */
        /*
        if ( $captiontag && trim($attachment->post_excerpt) ) {
            $output .= "
                <{$captiontag} class='wp-caption-text gallery-caption'>
                " . wptexturize($attachment->post_excerpt) . "
                </{$captiontag}>";
        }*/
        $output .= "</{$itemtag}>";
        if ( $columns > 0 && ++$i % $columns == 0 )
            $output .= '<br style="clear: both" />';
    }

    /**
     * this is the extra br you want to remove so we change it to jus closing div tag
     * #3 in question
     */
    /*$output .= "
            <br style='clear: both;' />
        </div>\n";
     */

    $output .= "</div>\n";
    return $output;
}
add_filter("post_gallery", "fanoe_my_own_gallery",10,2);




/**
 * Menu fallback. Link to the menu editor if that is useful.
 *
 * @param  array $args
 * @return string
 */
function fanoe_link_to_menu_editor( $args )
{
    if ( ! current_user_can( 'manage_options' ) )
    {
        return;
    }

    // see wp-includes/nav-menu-template.php for available arguments
    extract( $args );

    $link = $link_before
        . '<a href="' .admin_url( 'nav-menus.php' ) . '">' . $before . __('Add a menu', 'fanoe') . $after . '</a>'
        . $link_after;

    // We have a list
    if ( FALSE !== stripos( $items_wrap, '<ul' )
        or FALSE !== stripos( $items_wrap, '<ol' )
    )
    {
        $link = "<li>$link</li>";
    }

    $output = sprintf( $items_wrap, $menu_id, $menu_class, $link );
    if ( ! empty ( $container ) )
    {
        $output  = "<$container class='$container_class' id='$container_id'>$output</$container>";
    }

    if ( $echo )
    {
        echo $output;
    }

    return $output;
}


//Customizer


function fanoe_customize_register( $wp_customize ) {
	$colors = array();
	$colors[] = array(
		'slug'=>'design_color', 
		'default' => '#27ae60',
		'label' => __('Main Color of the Design', 'fanoe')
	);
	foreach( $colors as $color ) {
		// SETTINGS
		$wp_customize->add_setting(
			$color['slug'], array(
				'default' => $color['default'],
				'capability' => 
				'edit_theme_options',
			)
		);
		// CONTROLS
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				$color['slug'], 
				array('label' => $color['label'], 
				'section' => 'colors',
				'settings' => $color['slug'])
			)
		);
		
	}
	$contents = array();
	$contents[] = array(
		'slug'=>'share_btns_blogview', 
		'default'=>1,
		'label' => __( 'Share Buttons in the blog view', 'fanoe' )
	);
	$contents[] = array(
		'slug'=>'share_btns_singleview', 
		'default'=>1,
		'label' => __( 'Share Buttons in the single view', 'fanoe' )
	);
	$contents[] = array(
		'slug'=>'author_bio', 
		'default'=>1,
		'label' => __( 'Diplay the Author Bio in the single view also on a single-author blog.', 'fanoe' )
	);
	foreach( $contents as $content ) {
		$wp_customize->add_setting( $content['slug'], array(
			'default' => $content['default'],
		) );	
			 
		$wp_customize->add_control( $content['slug'], array(
			'settings' => $content['slug'],
			'label'    => $content['label'],
			'section'  => 'content',
			'type'     => 'checkbox',
		) );		
	}
	$backgrounds = array();
	$backgrounds[] = array(
		'slug'=>'background_size', 
		'default' => 'standard',
		'label' => __( 'Change the Size of the Header Background Image', 'fanoe' )
	);
	foreach( $backgrounds as $background ) {
		// SETTINGS
		$wp_customize->add_setting(
			$background['slug'], array(
				'default' => $background['default'],
				'capability' => 
				'edit_theme_options',
			)
		);
		// CONTROLS
		$wp_customize->add_control($background['slug'], array(
			'label'      => $background['label'],
			'section'    => 'header_image',
			'settings'   => $background['slug'],
			'type'       => 'radio',
			'choices'    => array(
				'standard'   => 'Standard',
				'cover' => __('The Image fills out the whole header', 'fanoe'),
				'height' => __('100% Height, Auto Width', 'fanoe'),
			),
		));
	}
	class fanoe_Customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';
		public function render_content() {
	?>
	
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
		</label>
	
	<?php
		}
	}
	class fanoe_Customize_Input_Control extends WP_Customize_Control {
		public $type = 'input';
		public function render_content() {
	?>
	
		<label>
			<span class="customize-control-title"><?php echo __('Copyright', 'fanoe') ?></span>
			<input type="text" value="<?php echo htmlspecialchars(get_theme_mod( 'copyright' ));?>" style="width:100%;" <?php $this->link(); ?>></input>
		</label>
	
	<?php
		}
	}
	$wp_customize->add_setting('custom_css', array('default' => '',));
	$wp_customize->add_control(new fanoe_Customize_Textarea_Control($wp_customize, 'custom_css', array(
		'label' => 'Custom CSS',
		'section' => 'css',
		'settings' => 'custom_css',
	)));
	$wp_customize->add_section('css' , array(
		'title' => __('CSS','fanoe'),
	));
	$wp_customize->add_setting('copyright', array('default' => '',));
	$wp_customize->add_control(new fanoe_Customize_Input_Control($wp_customize, 'copyright', array(
		'label' => 'Copyright',
		'section' => 'content',
		'settings' => 'copyright',
	)));
	$wp_customize->add_section('content' , array(
		'title' => __('Content','fanoe'),
	));
}
add_action( 'customize_register', 'fanoe_customize_register' );

?>
<?php // Custom CSS for Link Colors
function fanoe_insert_custom(){
	$text_color   = get_header_textcolor();
	$header_image = get_header_image();
	$design_color = get_theme_mod('design_color');
	?>
    <style>::selection {background:<?php echo $design_color ; ?>;color: #fff;}::-moz-selection {background:<?php echo $design_color ; ?>;color: #fff;}a,.format-status header h1 a:hover, .format-status header h1 a:active, .format-status header h1 a:focus,.site-title a:hover, .site-title a:active, .site-title a:focus {color: <?php echo $design_color ; ?>;}a:focus,a:active,a:hover,.format-status,input[type=reset]:hover, input[type=submit]:hover, input[type=reset]:active, input[type=submit]:active, input[type=reset]:focus, input[type=submit]:focus{background:<?php echo $design_color ; ?>;}input[type=text]:hover,input[type=password]:hover,input[type=email]:hover,input[type=url]:hover,input[type=number]:hover,textarea:hover,input[type=text]:focus,input[type=password]:focus,input[type=email]:focus,input[type=url]:focus,input[type=number]:focus,textarea:focus {border-color:<?php echo $design_color ; ?>}.bypostauthor, .active-sidebar #sidebar{border-left-color:<?php echo $design_color ; ?>}
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
		#branding{
			height:122px;
		}
	<?php
			if ( empty( $header_image ) ) :
	?>
		.site-header .home-link {
			min-height: 0;
		}
		#branding{
			height:0px;
		}
	<?php
			endif;

		// If the user has set a custom color for the text, use that.
		elseif ( $text_color != get_theme_support( 'custom-header', 'default-text-color' ) ) :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo esc_attr( $text_color ); ?>;
		}
	<?php endif; ?>
	</style>
    <?php
   
} 

add_action('wp_head', 'fanoe_insert_custom');?>