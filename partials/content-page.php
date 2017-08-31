<?php
/**
 * Partial to display page content.
 *
 * @version 2.0.0
 *
 * @package Fanoe
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>
	<?php
	/**
	 * Display the edit link.
	 */
	edit_post_link( __( 'Edit', 'fanoe' ), '<footer class="entry-footer"><p class="edit-link">', '</p></footer>' ); ?>
</article>
