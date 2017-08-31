<?php
/**
 * Partial to display if nothing was found.
 *
 * @version 2.0.0
 *
 * @package Fanoe
 */

?>
<article class="post no-results not-found">
	<header class="entry-header">
		<h1 class="entry-title"><?php _e( 'Nothing Found', 'fanoe' ); ?></h1>
	</header>
	<div class="entry-content">
		<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'fanoe' ); ?></p>
		<?php
		/**
		 * Display search form.
		 */
		get_search_form(); ?>
	</div>
</article>
