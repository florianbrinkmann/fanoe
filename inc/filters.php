<?php
/**
 * All add_filter() calls.
 *
 * @version 2.0.0
 *
 * @package Fanoe
 */

/**
 * Remove jump to hash on more link.
 */
add_filter( 'the_content_more_link', 'fanoe_remove_more_jump_link' );
