<?php
/**
 * All add_action() calls.
 *
 * @version 2.0.0
 *
 * @package Fanoe
 */

/**
 * Load the translation.
 */
add_action( 'after_setup_theme', 'fanoe_load_translation' );

/**
 * Run add_theme_support() functions.
 */
add_action( 'after_setup_theme', 'fanoe_add_theme_support' );

/**
 * Set the content width.
 */
add_action( 'after_setup_theme', 'fanoe_set_content_width' );

/**
 * Enqueue scripts and styles.
 */
add_action( 'wp_enqueue_scripts', 'fanoe_scripts_styles' );

/**
 * Register the widget area.
 */
add_action( 'widgets_init', 'fanoe_register_sidebar' );

/**
 * Register customize controls and settings.
 */
add_action( 'customize_register', 'fanoe_customize_register' );

/**
 * Insert Customize CSS into header.
 */
add_action( 'wp_head', 'fanoe_insert_customize_css' );
