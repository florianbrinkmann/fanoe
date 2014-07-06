<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	
    <title><?php wp_title( '|', true, 'right' );?></title>
    
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    
    <?php wp_head();?>
</head>

<body <?php body_class('nojs'); ?>>
	<div id="wrapper">
		<header id="branding" role="banner" <?php $header_image = get_header_image();
            if ( ! empty( $header_image ) ) : ?>
                style="background:url('<?php echo esc_url( $header_image ); ?>') no-repeat 50% 0;<?php $background_size = get_theme_mod( 'background_size' ); if($background_size =='cover'){ ?>-webkit-background-size:cover;background-size:cover;<?php }elseif($background_size =='height'){ ?>-webkit-background-size:auto 100%;background-size:auto 100%;<?php } ?>"
            <?php endif; ?>>
            <?php
		// Has the text been hidden?
		$header_image = get_header_image();
		if ( ! display_header_text() ) :
			if ( ! empty( $header_image ) ) :
			?>
            	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="home-link"></a>
            <?php
			endif;
			?>

	<?php endif; ?>
            <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php if (get_bloginfo( 'description' ) ): ?>
                <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
            <?php endif;?>
            
            <a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'fanoe' ); ?>"><?php _e( 'Skip to content', 'fanoe' ); ?></a>
            <a class="sidebar-button<?php $sidebar_btn = get_theme_mod( 'sidebar_btn' ); if ($sidebar_btn != ""){echo " text";}else{echo " stripes";}?><?php if ( is_admin_bar_showing() ) { echo " admin-bar"; }?>" href="#sidebar-menu"><?php if ($sidebar_btn != ""){echo $sidebar_btn;}else{?>≡<?php }?></a>
            
            
		</header>