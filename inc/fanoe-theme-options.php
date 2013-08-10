<?php
/**
 * Define our settings sections
 *
 * array key=$id, array value=$title in: add_settings_section( $id, $title, $callback, $page );
 * @return array
 */
function fanoe_options_page_sections() {
	
	$sections = array();
	// $sections[$id] 				= __($title, 'fanoe');
	$sections['txt_section'] 		= __('', 'fanoe');
	$sections['txtarea_section'] 	= __('', 'fanoe');
	$sections['checkbox_section'] 	= __('', 'fanoe');
	
	return $sections;	
}

/**
 * Define our form fields (settings) 
 *
 * @return array
 */
function fanoe_options_page_fields() {
	// Text Form Fields section
	$options[] = array(
		"section" => "txt_section",
		"id"      => fanoe_SHORTNAME . "_copyright_input",
		"title"   => __( 'Copyright Text', 'fanoe' ),
		"desc"    => __( 'Here you can write in your copyright text. <b>If the field is empty, the copyright symbol, the current year and the name of the blog is displayed.</b> Some inline HTML (&lt;a&gt;, &lt;b&gt;, &lt;em&gt;, &lt;i&gt;, &lt;strong&gt;) is allowed.', 'fanoe' ),
		"type"    => "text",
		"std"     => __('','fanoe')
	);
	$options[] = array(
		"section" => "txt_section",
		"id"      => fanoe_SHORTNAME . "_design_color",
		"class"	  => "color",
		"title"   => __( 'Design Color', 'fanoe' ),
		"desc"    => __( 'Here you can enter the main color of the design. Standard is 27AE60. In the "Help" at the top, there is more information.', 'fanoe' ),
		"type"    => "text",
		"std"     => "27AE60"
	);

	// Checkbox Form Fields section
	$options[] = array(
		"section" => "checkbox_section",
		"id"      => fanoe_SHORTNAME . "_social_blog",
		"title"   => __( 'Share Buttons in the <b>blog view</b>', 'fanoe' ),
		"desc"    => __( 'Remove the hook for the social media share buttons are not displayed in the blog view.', 'fanoe' ),
		"type"    => "checkbox",
		"std"     => 1 // 0 for off
	);	
	$options[] = array(
		"section" => "checkbox_section",
		"id"      => fanoe_SHORTNAME . "_social_single",
		"title"   => __( 'Share buttons in the <b>single view</b>', 'fanoe' ),
		"desc"    => __( 'Remove the hook for the social media share buttons are not displayed in single view.', 'fanoe' ),
		"type"    => "checkbox",
		"std"     => 1 // 0 for off
	);	
	$options[] = array(
		"section" => "checkbox_section",
		"id"      => fanoe_SHORTNAME . "_author_bio",
		"title"   => __( 'Author Bio', 'fanoe' ),
		"desc"    => __( 'Remove the hook so that the author bio in the single view is only displayed in multi-author blogs.', 'fanoe' ),
		"type"    => "checkbox",
		"std"     => 1 // 0 for off
	);	
	
	$options[] = array(
		"section" => "txtarea_section",
		"id"      => fanoe_SHORTNAME . "_custom_css",
		"title"   => __( 'Custom CSS', 'fanoe' ),
		"desc"    => __( 'Here you can place your own CSS. In the "Help" at the top, there is more information.', 'fanoe' ),
		"type"    => "textarea",
		"std"     => __('','fanoe'),
		"class"   => "allowlinebreaks"
	);

	

	
	return $options;	
}

// adapted from http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/

 ?>